using Microsoft.AspNetCore.Mvc;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class ChatController : Controller
    {
        private readonly IChatServices _chatServices;
        private readonly IUserServices _userServices;

        public ChatController(IChatServices chatServices, IUserServices userServices)
        {
            _chatServices = chatServices;
            _userServices = userServices;
        }

        public async Task<IActionResult> Index()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var chatsUser = await _chatServices.GetChatAsync(new Services.Model.ChatModel() { ChatUserId = currentUser.Id });

            var chatConnectionUser = await _chatServices.GetChatAsync(new Services.Model.ChatModel() { ChatConnectionUserId = currentUser.Id });

            var chatsALL = chatsUser.Concat(chatConnectionUser).ToList();

            var chats = new List<Services.Model.ChatModel>();

            foreach (var chat in chatsALL)
            {
                if (!chats.Where(x => x.ConnectionUserUserName == chat.ConnectionUserUserName).Any())
                {
                    var chatUnique = chatsALL.Where(x => x.ConnectionUserUserName == chat.ConnectionUserUserName).LastOrDefault();

                    chats.Add(chatUnique);
                }
            }

            return View(chats);
        }
        public JsonResult ChatList(int connectionUserId)
        {
            return new JsonResult(new ResultModel()
            {
                StatusCode = HttpStatusCode.OK,
                IsOK = true,
                Data = connectionUserId,
                Errors = null,
            });
        }

        public async Task<IActionResult> Details(int connectionUserId)
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var questions = (await GetChatQuestionAsync(currentUser.Id, connectionUserId)).ToList().Where(x => x.Message != null);

            var responses = (await GetChatResponseAsync(currentUser.Id, connectionUserId)).ToList().Where(x => x.Message != null);

            var chats = questions.Concat(responses).ToList();

            chats = chats.OrderBy(x => x.DateMessage).ToList();

            ViewBag.ConnectionUserId = connectionUserId;
            return View(chats);
        }

        private async Task<List<ChatViewModel>> GetChatQuestionAsync(int userId, int connectionUserId)
        {
            var questions = (await _chatServices.GetChatAsync(new Services.Model.ChatModel() { ChatUserId = userId, ChatConnectionUserId = connectionUserId})).ToList();

            var chats = new List<ChatViewModel>();

            if (questions.Count > 0)
            {

                questions.ForEach(x =>
                {
                    chats.Add(new ChatViewModel()
                    {
                        Message = x.ChatMessage,
                        Question = true,
                        UserId = x.ChatUserId.Value,
                        ConnectionUserId = x.ChatConnectionUserId.Value,
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
                if (user != null) { userName = user.FirstOrDefault().UserName; };
                chats.Add(new ChatViewModel()
                {
                    ConnectionUserId = connectionUserId,
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

        private async Task<List<ChatViewModel>> GetChatResponseAsync(int userId, int connectionUserId)
        {
            var questions = (await _chatServices.GetChatAsync(new Services.Model.ChatModel() { ChatConnectionUserId = userId, ChatUserId = connectionUserId })).ToList();

            var chats = new List<ChatViewModel>();

            if (questions.Count > 0)
            {
                questions.ForEach(x =>
                {
                    chats.Add(new ChatViewModel()
                    {
                        Message = x.ChatMessage,
                        Question = false,
                        ConnectionUserId = x.ChatConnectionUserId.Value,
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
                if (user != null) { userName = user.FirstOrDefault().UserName; };
                chats.Add(new ChatViewModel()
                {
                    Message = null,
                    Question = false,
                    UserId = userId,
                    Username = userName,
                    IsUnread = true,
                    ConnectionUserId = connectionUserId,
                    DateMessage = DateTime.Now,
                });
            }
            return chats;
        }

        [HttpGet]
        public async Task<JsonResult> UpdateIsReaded(string usernameConnectionChat)
        {
            var currentUser = _userServices.CurrentUserAsync();

            var user = await _userServices.GetUserAsync(new UserModel() { UserName = usernameConnectionChat });

            var result = await _chatServices.UpdateChatIsReadedAsync(new Services.Model.ChatModel()
            {
                ConnectionUserUserName = usernameConnectionChat,
                ChatIsRead = true,
                ChatUserId = currentUser.Id
            });

            return new JsonResult(new ResultModel()
            {
                StatusCode = result > 0 ? HttpStatusCode.OK : HttpStatusCode.BadRequest,
                IsOK = result > 0,
                Data = "Update data has been changed successfully",
                Errors = "Update readed error",
                Redirect = "/Chat/Details?connectionUserId=" + user.FirstOrDefault().Id
            });
        }
        public async Task<JsonResult> Add([FromBody]ChatViewModel model)
        {
            var result = await _chatServices.AddChatAsync(new Services.Model.ChatModel()
            {
                ChatConnectionUserId = model.ConnectionUserId,
                ChatIsRead = false,
                ChatUserId = model.UserId,
                ChatMessage = model.Message
            });

            return new JsonResult(new ResultModel()
            {
                StatusCode = result > 0 ? HttpStatusCode.OK : HttpStatusCode.BadRequest,
                IsOK = result > 0,
                Data = "Add data has been changed successfully",
                Errors = "Add new messagem error",
                Redirect = "/Chat/Details?connectionUserId=" + model.ConnectionUserId
            });

        }
    }
}
