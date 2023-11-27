using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers
{
    public class ChatController : Controller
    {
        private readonly IChatServices _chatServices;
        private readonly IUserServices _userServices;
        private readonly ILogger<ChatController> _logger;
        private string id = string.Empty;

        public ChatController(IChatServices chatServices, IUserServices userServices, ILogger<ChatController> logger)
        {
            _chatServices = chatServices;
            _userServices = userServices;
            _logger = logger;
        }
        //[Authorize]
        public async Task<IActionResult> Unread()
        {
            if (!User.Identity.IsAuthenticated) return RedirectToAction("Index", "Login");
            var responses = await GroupDataResponse();

            var chatView = new List<ChatViewModel>();



            foreach (var response in responses)
            {
                if (response.Value.OrderByDescending(x => x.DateMessage).FirstOrDefault().IsUnread) continue;

                chatView.Add(new ChatViewModel()
                {
                    Username = response.Key,
                    Message = response.Value.OrderByDescending(x => x.DateMessage).FirstOrDefault().Message,
                    UserId = response.Value.OrderByDescending(x => x.DateMessage).FirstOrDefault().UserId,
                    DateMessage = response.Value.OrderByDescending(x => x.DateMessage).FirstOrDefault().DateMessage,
                    CountUnread = response.Value.Where(x => !x.IsUnread).Count()
                });
            }

            TempData["ChatUnread"] = chatView.Where(x => x.IsUnread == false).ToList();

            return View();
        }

		//[Authorize]
		public async Task<IActionResult> UpdateIsReaded([FromBody] int userId)
		{
            if (!User.Identity.IsAuthenticated) return RedirectToAction("Index", "Login");
            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;

            var result = await _chatServices.UpdateChatIsReadedAsync(new Services.Model.ChatModel()
            {
                ChatConnectionUserId = Convert.ToInt32(id),
                ChatIsRead = true,
                ChatUserId = userId
            });

            return new JsonResult(result);
        }
        //[Authorize]
        public async Task<IActionResult> All()
        {
            if (!User.Identity.IsAuthenticated) return RedirectToAction("Index", "Login");

            var responses = await GroupDataResponse();

			var chatView = new List<ChatViewModel>();

			foreach (var response in responses)
			{
				chatView.Add(new ChatViewModel()
				{
					Username = response.Key,
					Message = response.Value.OrderByDescending(x => x.DateMessage).FirstOrDefault().Message,
					UserId = response.Value.OrderByDescending(x => x.DateMessage).FirstOrDefault().UserId,
					DateMessage = response.Value.OrderByDescending(x => x.DateMessage).FirstOrDefault().DateMessage,
					CountUnread = response.Value.Where(x => !x.IsUnread).Count()
				});
			}

			TempData["ChatAll"] = chatView;

			return View();

        }
        //[Authorize]
        public async Task<IActionResult> Details(int userId)
        {
            if (!User.Identity.IsAuthenticated) return RedirectToAction("Index", "Login");

            var questions = (await GetChatQuestionAsync(userId)).ToList();

            var responses = (await GetChatResponseAsync(userId)).ToList();

			var chats = questions.Concat(responses);

			TempData["ChatDetails"] = chats.ToList();

            return View();
        }
        //[Authorize]
        public async Task<JsonResult> Add(ChatViewModel model)
		{

            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;

			var result = await _chatServices.AddChatAsync(new Services.Model.ChatModel()
			{
				ChatConnectionUserId = model.UserId,
				ChatIsRead = false,
				ChatUserId = Convert.ToInt32(id),
				ChatMessage = model.Message
			});

			return new JsonResult(result);

		}
        //[Authorize]
        private async Task<Dictionary<string, List<ChatViewModel>>> GroupDataQuestion()
        {
            id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;

            var resultUser = (await _chatServices.GetChatAsync(new Services.Model.ChatModel() { ChatUserId = Convert.ToInt32(id) })).ToList();

			Dictionary<string, List<ChatViewModel>> groupedDataQuestion = new Dictionary<string, List<ChatViewModel>>();

			foreach (var message in resultUser)
			{
				if (!groupedDataQuestion.ContainsKey(message.ChatUserUserName))
				{
					groupedDataQuestion[message.ChatUserUserName] = new List<ChatViewModel>();
				}

				groupedDataQuestion[message.ChatUserUserName].Add(new ChatViewModel
				{              
					Username = message.ChatUserUserName,
					Message = message.ChatMessage,
					DateMessage = message.ChatCreatedDate.Value,
					CountUnread = resultUser.Where(x => x.ChatUserUserName == message.ChatUserUserName && x.ChatIsRead == false).Count(),
					IsUnread = message.ChatIsRead.Value,
                    UserId = message.ChatUserId.Value
				});
			}

			return groupedDataQuestion;

		}
        //[Authorize]
        private async Task<Dictionary<string, List<ChatViewModel>>> GroupDataResponse()
		{

			id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;

			var resultConnection = (await _chatServices.GetChatAsync(new Services.Model.ChatModel() { ChatConnectionUserId = Convert.ToInt32(id) })).ToList();

			Dictionary<string, List<ChatViewModel>> groupedDataResponse = new Dictionary<string, List<ChatViewModel>>();

			foreach (var message in resultConnection)
			{
				if (!groupedDataResponse.ContainsKey(message.ChatUserUserName))
				{
					groupedDataResponse[message.ChatUserUserName] = new List<ChatViewModel>();
				}

				groupedDataResponse[message.ChatUserUserName].Add(new ChatViewModel
				{
					Username = message.ChatUserUserName,
					Message = message.ChatMessage,
					DateMessage = message.ChatCreatedDate.Value,
					CountUnread = resultConnection.Where(x => x.ChatUserUserName == message.ChatUserUserName && x.ChatIsRead == false).Count(),
					IsUnread = message.ChatIsRead.Value,
					UserId = message.ChatUserId.Value
				});
			}

			return groupedDataResponse;
		}
        //[Authorize]
        private async Task<List<ChatViewModel>> GetChatQuestionAsync(int userId)
		{
			var questions =(await _chatServices.GetChatAsync(new Services.Model.ChatModel() { ChatConnectionUserId = userId })).ToList();

			var chats = new List<ChatViewModel>();

			if(questions.Count > 0) {

            questions.ForEach(x =>
			{
				chats.Add(new ChatViewModel()
				{ 
					Message = x.ChatMessage,
					Question = true,
					UserId =x.ChatUserId.Value,
					Username = x.ChatUserUserName,
					IsUnread = x.ChatIsRead.Value,
					DateMessage =x.ChatCreatedDate.Value, 
				});
			} );
            }
            else
            {
                var user = await _userServices.GetUserAsync(new UserModel() { Id = userId });
                string userName = null;
                if (user != null) { userName = user.FirstOrDefault().UserName; };
                chats.Add(new ChatViewModel()
                {
                    Message = null,
                    Question = true,
                    UserId = userId,
                    Username = userName,
                    IsUnread = true,
                    DateMessage = DateTime.Now,
                });
            }
            return chats;
        }
        //[Authorize]
        private async Task<List<ChatViewModel>> GetChatResponseAsync(int userId)
        {
            var questions = (await _chatServices.GetChatAsync(new Services.Model.ChatModel() { ChatUserId = userId })).ToList();

            var chats = new List<ChatViewModel>();

            if(questions.Count > 0) {  
            questions.ForEach(x =>
            {
                chats.Add(new ChatViewModel()
                {
                    Message = x.ChatMessage,
                    Question = false,
                    UserId = x.ChatUserId.Value,
                    Username = x.ChatUserUserName,
                    IsUnread = x.ChatIsRead.Value,
                    DateMessage = x.ChatCreatedDate.Value,
                });
            });
            }
            else
            {
                var user = await _userServices.GetUserAsync(new UserModel() { Id = userId });
                string userName = null;
                if(user != null) { userName = user.FirstOrDefault().UserName; };
                chats.Add(new ChatViewModel()
                {
                    Message = null,
                    Question = false,
                    UserId = userId,
                    Username = userName,
                    IsUnread = true,
                    DateMessage = DateTime.Now,
                });
            }
            return chats;
        }
    }
}