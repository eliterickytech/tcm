using Microsoft.AspNetCore.Mvc;
using TCM.Services.Interfaces.Services;
using TCM.Services.Services;
using System.Linq;
using TCM.Services.Model.Enum;
using TCM.Presentation.Site.Models;
using System.Threading.Tasks;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class HomeController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly IBannerServices _bannerServices;
        private readonly ICollectionServices _collectionServices;
        private readonly ICollectionItemServices _collectionItemServices;

        public HomeController(IUserServices userServices, IBannerServices bannerServices, ICollectionServices collectionServices, ICollectionItemServices collectionItemServices)
        {
            _userServices = userServices;
            _bannerServices = bannerServices;
            _collectionServices = collectionServices;
            _collectionItemServices = collectionItemServices;
        }

        public async Task<IActionResult> Index()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            HomeViewModel model = new HomeViewModel();

            var banners = await _bannerServices.GetBannerAsync();

            model.BannersModel = banners.ToList();

            var collections = await _collectionServices.GetCollectionAsync();

            model.CollectionsModel = collections.ToList();

            foreach (var collection in collections)
            {
                var collectionItems = await _collectionItemServices.GetCollectionItemAsync(collection.Id, null);

                var collectionItem = collectionItems.Where(x => x.CollectionItemTypeId == (int)CollectionItemType.MiniImage).FirstOrDefault();

                model.CollectionsItemModel.Add(collectionItem);
            }
            string pathView = string.Empty;

            return View(model);

        }
    }
}
