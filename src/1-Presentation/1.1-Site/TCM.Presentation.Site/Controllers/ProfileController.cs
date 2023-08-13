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

        public ProfileController(ICollectionServices collectionServices, IConnectionServices connectionServices, IChatServices chatServices, ICollectionItemServices collectionItemServices, ICollectionItemUserServices collectionItemUserServices)
        {
            _collectionServices = collectionServices;
            _connectionServices = connectionServices;
            _chatServices = chatServices;
            _collectionItemServices = collectionItemServices;
            _collectionItemUserServices = collectionItemUserServices;

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


        private async Task FillProfiles(int userId, bool isConnection)
        {
            HomeViewModel model = new HomeViewModel();
            var connectionMult = 0;
            model.Id = userId;

            var resultUsers = (await _connectionServices.GetConnectionAsync(Convert.ToInt32(userId))).Where(x => x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved);
            var resultConnections = (await _connectionServices.GetConnectionAsync(new ConnectionModel() { ConnectionUserId = Convert.ToInt32(userId) })).Where(x => x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved);
            var results = resultUsers.Concat(resultConnections).ToList();
            
            if (isConnection)
            {
                var resultUsersMulti = (await _connectionServices.GetConnectionAsync(Convert.ToInt32(model.Id))).Where(x => x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved);
                var resultConnectionsMulti = (await _connectionServices.GetConnectionAsync(new ConnectionModel() { ConnectionUserId = Convert.ToInt32(model.Id) })).Where(x => x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved);
                var resultMulti = resultUsersMulti.Concat(resultConnectionsMulti);

                results.ForEach(x =>
                {
                    connectionMult += resultMulti.Where(y => y.ConnectionUserId == x.ConnectionUserId).Count();
                });
                if (connectionMult > 1)
                {
                    if (userId > 1)
                    {
                        connectionMult -= 1;
                    }
                }

            }

            model.ConnectionMulti = connectionMult;

            var countCollectionCompleted =await _collectionServices.GetCountCollectionCompletedAsync(userId);
            var countConnection = results.Count();
            var countChateUnRead = (await GetChatCountUnreadAsync(userId)).Count();
            var connection = await _connectionServices.GetConnectionAsync(userId);
            var collections = await _collectionServices.GetCollectionAsync();

            model.CollectionsModel = collections?.ToList();

            TempData["CountCollectionCompleted"] = countCollectionCompleted;
            TempData["CountConnections"] = countConnection;
            TempData["CountChatsUnRead"] = countChateUnRead;
            TempData["IsConnection"] = isConnection;
            TempData["Model"] = model;
            TempData["connectionMult"] = connectionMult;

            if (isConnection)
            {
                TempData["ConnectionDate"] = results?.Where(x => x.UserConnectionId == userId && x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved)?.FirstOrDefault()?.ConnectionUserCreatedDate;
                TempData["NameConnection"] = results?.Where(x => x.UserConnectionId == userId && x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved)?.FirstOrDefault()?.UserConnectionUsername;
                TempData["ConnectionUserConnectionStatusId"] = results?.Where(x => x.UserConnectionId == userId && x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved)?.FirstOrDefault()?.ConnectionUserConnectionStatusId;
                TempData["ConnectionUserId"] = results?.Where(x => x.UserConnectionId == userId && x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved)?.FirstOrDefault()?.UserConnectionId;
            }
            else
            {
                TempData["ConnectionDate"] = results?.Where(x => x.UserId == userId && x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved)?.FirstOrDefault()?.ConnectionUserCreatedDate;
                TempData["NameConnection"] = results?.Where(x => x.UserId == userId && x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved)?.FirstOrDefault()?.UserUsername;
                TempData["ConnectionUserConnectionStatusId"] = results?.Where(x => x.UserId == userId && x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved)?.FirstOrDefault()?.ConnectionUserConnectionStatusId;
                TempData["ConnectionUserId"] = results?.Where(x => x.UserId == userId && x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved)?.FirstOrDefault()?.UserId;
            }
        }

        private async Task<List<ChatModel>> GetChatCountUnreadAsync(int userId)
        {
            var resultUser = (await _chatServices.GetChatAsync(new ChatModel() { ChatUserId = userId } )).ToList();

            var resultConnection = (await _chatServices.GetChatAsync(new ChatModel() { ChatConnectionUserId = userId } )).ToList();

            return resultUser.Concat(resultConnection).ToList().Where(x => !x.ChatIsRead.Value).ToList();
        }
    }
}
