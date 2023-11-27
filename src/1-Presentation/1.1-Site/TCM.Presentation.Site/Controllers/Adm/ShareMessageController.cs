using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers.Adm
{
    public class ShareMessageController : Controller
    {
        private readonly ICollectionServices _collectionServices;
        private readonly IUserServices _userServices;
        private readonly IChatServices _chatServices;

        public ShareMessageController(ICollectionServices collectionServices, IUserServices userServices, IChatServices chatServices)
        {
            _collectionServices = collectionServices;
            _userServices = userServices;
            _chatServices = chatServices;

        }

        public async Task<IActionResult> Index()
        {
            TempData["CountCollection"] = await GetCountCollectionAsync();
            TempData["Id"] = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;

            return View();
        }

        private async Task<int> GetCountCollectionAsync()
        {
            return (await _collectionServices.GetCollectionAsync()).Count();
        }

        [HttpGet]
        public async Task<IActionResult> ListUsers(string q)
        {
            var users = await _userServices.GetUserAsync(new Services.Model.UserModel() { UserName = q });
            var results = new List<Results>();
            var select = new SelectUserModel();

            foreach (var user in users)
            {
                var result = new Results();
                result.id = user.Id.Value;
                result.text = user.UserName;

                results.Add(result);
            }

            select.results = results;
            select.pagination = new Pagination() { more = false };
            return Json(select);
        }

        public async Task<IActionResult> SendShareMessage(string myText, int userOption, int[] userList, int dateOption, DateTime date) 
        {
            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;

            IEnumerable<UserModel> userSendMessage = Enumerable.Empty<UserModel>();

            if (userOption == 1 && (userList == null || userList.Length == 0))
            {
                userSendMessage = await _userServices.ListUserAsync(); 
            }
            else if (userList != null && userList.Length > 0)
            {
                
                foreach (var user in userList)
                {
                    UserModel userModel = new UserModel();
                    userModel.Id = user;
                    userSendMessage = await _userServices.GetUserAsync(userModel);
                }
            }

            if(dateOption == 1) { date =  DateTime.Now; }

            if (userSendMessage.Any())
            {
                foreach (var user in userSendMessage)
                {
                    if (user.Id != Convert.ToInt32(id))
                    {
                        var result = await _chatServices.AddChatScheduledAsync(new ChatModel()
                        {
                            ChatConnectionUserId = Convert.ToInt32(id),
                            ChatIsRead = false,
                            ChatUserId = user.Id ,
                            ChatMessage = myText,
                            ChatCreatedDate = date
                        });
                    }
                }
            }          
            return Json(new { StatusCode = System.Net.HttpStatusCode.OK, IsOK = true, Data = userList.Length, Redirect = "" });

        }


    }
}
