using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System.Linq;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;

namespace TCM.Presentation.Controllers
{
    public class HomeController : Controller
	{
		private readonly ILogger<HomeController> _logger;
		private readonly IBannerServices _bannerServices;
		private readonly ICollectionServices _collectionServices;
        private readonly ICollectionItemServices _collectionItemServices;

        public HomeController(ILogger<HomeController> logger,
            IBannerServices bannerServices,
            ICollectionServices collectionServices,
            ICollectionItemServices collectionItemServices)
        {
            _logger = logger;
            _bannerServices = bannerServices;
            _collectionServices = collectionServices;
            _collectionItemServices = collectionItemServices;
        }
        [AllowAnonymous]
        public async Task<IActionResult> Index()
		{
			//if (!User.Identity.IsAuthenticated) return RedirectToAction("Index", "Login");

			HomeViewModel model = new HomeViewModel();

			var banners = await _bannerServices.GetBannerAsync();

            model.BannersModel = banners.ToList();

            var collections = await _collectionServices.GetCollectionAsync();

            model.CollectionsModel = collections.ToList();

            foreach (var collection in collections)
            {
                var collectionItems = await _collectionItemServices.GetCollectionItemAsync(collection.Id);

                var collectionItem = collectionItems.Where(x => x.CollectionItemTypeId == 4).FirstOrDefault();

                model.CollectionsItemModel.Add(collectionItem);
            }

			return View(model);
		}
	}
}
