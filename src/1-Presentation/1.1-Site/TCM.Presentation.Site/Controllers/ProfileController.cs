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

        public async Task<IActionResult> Index()
        {
            await FillProfiles(1);

            return View();
        }

        private async Task FillProfiles(int userId)
        {
            HomeViewModel model = new HomeViewModel();

            var countCollectionCompleted =await _collectionServices.GetCountCollectionCompletedAsync(userId);
            var countConnection = await _connectionServices.GetCountConnectionAsync(userId);
            var countChateUnRead = await _chatServices.GetCountChatUnReadAsync(userId);

            var collections = await _collectionServices.GetCollectionAsync();

            model.CollectionsModel = collections.ToList();

            TempData["CountCollectionCompleted"] = countConnection;
            TempData["CountConnections"] = countConnection;
            TempData["CountChatsUnRead"] = countChateUnRead;

            TempData["Model"] = model;
        }
    }
}
