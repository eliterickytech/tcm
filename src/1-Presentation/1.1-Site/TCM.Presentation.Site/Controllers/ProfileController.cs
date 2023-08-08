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
        public async Task<IActionResult> Index(bool isConnection)
        {
            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "1";

            await FillProfiles(Convert.ToInt32(id), isConnection);

            return View();
        }
        [HttpPost]
        public async Task<IActionResult> Index(int connectionUserId, bool isConnection)
        {
            await FillProfiles(connectionUserId, isConnection);

            return View();
        }


        private async Task FillProfiles(int userId, bool isConnection)
        {
            HomeViewModel model = new HomeViewModel();

            var countCollectionCompleted =await _collectionServices.GetCountCollectionCompletedAsync(userId);
            var countConnection = await _connectionServices.GetCountConnectionAsync(userId);
            var countChateUnRead = await _chatServices.GetCountChatUnReadAsync(userId);
            var connection = await _connectionServices.GetConnectionAsync(userId);
            var collections = await _collectionServices.GetCollectionAsync();

            model.CollectionsModel = collections.ToList();
            TempData["ConnectionDate"] = connection.FirstOrDefault().ConnectionUserCreatedDate;
            TempData["NameConnection"] = connection.FirstOrDefault().UserConnectionUsername;
            TempData["CountCollectionCompleted"] = countCollectionCompleted;
            TempData["CountConnections"] = countConnection;
            TempData["CountChatsUnRead"] = countChateUnRead;

            TempData["IsConnection"] = isConnection;
            TempData["Model"] = model;
        }
    }
}
