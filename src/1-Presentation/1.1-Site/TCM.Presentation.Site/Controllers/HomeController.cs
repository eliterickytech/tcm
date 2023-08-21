using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System;
using System.Data;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model.Enum;

namespace TCM.Presentation.Controllers
{
    public class HomeController : Controller
	{
		private readonly ILogger<HomeController> _logger;
		private readonly IBannerServices _bannerServices;
		private readonly ICollectionServices _collectionServices;
        private readonly ICollectionItemServices _collectionItemServices;
        private readonly IUserServices _userServices;

        public HomeController(ILogger<HomeController> logger,
            IBannerServices bannerServices,
            ICollectionServices collectionServices,
            ICollectionItemServices collectionItemServices,
            IUserServices userServices)
        {
            _logger = logger;
            _bannerServices = bannerServices;
            _collectionServices = collectionServices;
            _collectionItemServices = collectionItemServices;
            _userServices = userServices;
        }
        [AllowAnonymous]
        public async Task<IActionResult> Index()
		{
            //if (!User.Identity.IsAuthenticated) return RedirectToAction("Index", "Login");
            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2";

            var user = (await _userServices.GetUserAsync(new Services.Model.UserModel() { Id = Convert.ToInt32(id) })).FirstOrDefault();

            HomeViewModel model = new HomeViewModel();

            var banners = await _bannerServices.GetBannerAsync();

            model.BannersModel = banners.ToList();

            var collections = await _collectionServices.GetCollectionAsync();

            model.CollectionsModel = collections.ToList();

            foreach (var collection in collections)
            {
                var collectionItems = await _collectionItemServices.GetCollectionItemAsync(collection.Id);

                var collectionItem = collectionItems.Where(x => x.CollectionItemTypeId == (int) CollectionItemType.MiniImage).FirstOrDefault();

                model.CollectionsItemModel.Add(collectionItem);
            }
            string pathView = string.Empty;

            return View(model);
		}
        public async Task<IActionResult> Adm()
        {
            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2";

            var user = (await _userServices.GetUserAsync(new Services.Model.UserModel() { Id = Convert.ToInt32(id) })).FirstOrDefault();

            HomeViewModel model = new HomeViewModel();

            var banners = await _bannerServices.GetBannerAsync();

            model.BannersModel = banners.ToList();

            var collections = await _collectionServices.GetCollectionAsync();

            model.CollectionsModel = collections.ToList();

            foreach (var collection in collections)
            {
                var collectionItems = await _collectionItemServices.GetCollectionItemAsync(collection.Id);

                var collectionItem = collectionItems.Where(x => x.CollectionItemTypeId == (int)CollectionItemType.MiniImage).FirstOrDefault();

                model.CollectionsItemModel.Add(collectionItem);
            }
            string pathView = string.Empty;

            return View(model);
        }
	}
}
