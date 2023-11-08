using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System.Linq;
using System.Threading.Tasks;
using System.Security.Claims;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using System.Collections.Generic;
using TCM.Presentation.Site.Models;
using Microsoft.VisualBasic;
using System;
using TCM.Services.Model.Enum;
using TCM.Services.Services;
using static Microsoft.ApplicationInsights.MetricDimensionNames.TelemetryContext;

namespace TCM.Presentation.Site.Controllers
{
    public class ProfileController : Controller
    {
        private readonly ILogger<ProfileController> _logger;
        private readonly ICollectionServices _collectionServices;
        private readonly ICollectionItemServices _collectionItemServices;
        private readonly ICollectionItemUserServices _collectionItemUserServices;
        private readonly IConnectionServices _connectionServices;
        private readonly IChatServices _chatServices;
        private readonly IUserServices _userServices;

        public ProfileController(ICollectionServices collectionServices, IConnectionServices connectionServices, IChatServices chatServices, ICollectionItemServices collectionItemServices, ICollectionItemUserServices collectionItemUserServices, IUserServices userServices)
        {
            _collectionServices = collectionServices;
            _connectionServices = connectionServices;
            _chatServices = chatServices;
            _collectionItemServices = collectionItemServices;
            _collectionItemUserServices = collectionItemUserServices;
            _userServices = userServices;
        }
        [HttpPost]
        public async Task<IActionResult> Index(int connectionUserId, bool isConnection)
        {
            await FillProfiles(connectionUserId, isConnection);

            return View();
        }

        [HttpGet]
        public async Task<IActionResult> Index(int connectionUserId, bool isConnection, bool fill = true)
        {
            if (!isConnection)
            {
                if (connectionUserId != 1)
                    connectionUserId = int.Parse( HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2");
            }
            await FillProfiles(connectionUserId, isConnection);

            return View();
        }
        [HttpGet]
        public async Task<IActionResult> Adm(int connectionUserId, bool isConnection, bool fill = true)
        {
            if (!isConnection)
            {
                if (connectionUserId != 1)
                    connectionUserId = int.Parse(HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2");
            }
            await FillProfiles(connectionUserId, isConnection);

            return View();
        }
        //[Authorize]
        private async Task FillProfiles(int userId, bool isConnection)
        {
            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2";

            HomeViewModel model = new HomeViewModel();

            model.Id = userId;

            UserModel userModel = new UserModel();
            userModel.Id = userId;
            var resultUser = (await _userServices.GetUserAsync(userModel)).Where(u => u.Id == userId);

            if (resultUser != null)
            {
                var user = resultUser.FirstOrDefault(u => u.Id == userId);
                TempData["NameConnection"] = user.FullName;
            }
            var resultUsers = (await _connectionServices.GetConnectionAsync(Convert.ToInt32(userId)))
                                .Where(connection => connection.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved).ToList();
            

            var resultConnections = (await _connectionServices.GetConnectionAsync(new ConnectionModel() { ConnectionUserId = Convert.ToInt32(userId) }));
            


            var results = resultUsers.Concat(resultConnections).ToList();

            var countCollectionCompleted =await _collectionServices.GetCountCollectionCompletedAsync(userId);
            var countConnection = results.Count();
            var countChateUnRead = (await GetChatCountUnreadAsync(userId)).Count();
            var collections = await _collectionServices.GetCollectionAsync();

            model.CollectionsModel = collections?.ToList();

            TempData["CountCollectionCompleted"] = countCollectionCompleted;
            TempData["CountConnections"] = countConnection;
            TempData["CountChatsUnRead"] = countChateUnRead;
            TempData["IsConnection"] = isConnection;
            TempData["Model"] = model;

            if (userId.ToString() == id)
            {
                TempData["ConnectionUserId"] = userId;
            }
            else
            {
                TempData["ConnectionDate"] = results?.Where(x => x.UserId == userId && x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved)?.FirstOrDefault()?.ConnectionUserCreatedDate;
                TempData["NameConnection"] = results?.Where(x => x.UserId == userId && x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved)?.FirstOrDefault()?.UserUsername;
                TempData["ConnectionUserConnectionStatusId"] = results?.Where(x => x.UserId == userId && x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved)?.FirstOrDefault()?.ConnectionUserConnectionStatusId;
                TempData["ConnectionUserId"] = results?.Where(x => x.UserId == userId && x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved)?.FirstOrDefault()?.UserId;
            }

        }
        //[Authorize]
        private async Task<List<ChatModel>> GetChatCountUnreadAsync(int userId)
        {
            var resultUser = (await _chatServices.GetChatAsync(new ChatModel() { ChatUserId = userId } )).ToList();

            var resultConnection = (await _chatServices.GetChatAsync(new ChatModel() { ChatConnectionUserId = userId } )).ToList();

            return resultUser.Concat(resultConnection).ToList().Where(x => !x.ChatIsRead.Value).ToList();
        }
    }
}
