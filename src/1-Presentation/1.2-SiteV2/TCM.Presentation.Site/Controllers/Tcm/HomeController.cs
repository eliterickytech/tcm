using Microsoft.AspNetCore.Mvc;
using TCM.Services.Interfaces.Services;
using TCM.Services.Services;
using System.Linq;
using TCM.Services.Model.Enum;
using TCM.Presentation.Site.Models;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Connections;
using TCM.Services.Model;
using System.Collections.Generic;
using System.Drawing;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class HomeController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly IBannerServices _bannerServices;
        private readonly ICollectionServices _collectionServices;
        private readonly ICollectionItemServices _collectionItemServices;
        private readonly ICollectionItemSharedServices _collectionItemSharedServices;

        public HomeController(IUserServices userServices, IBannerServices bannerServices, ICollectionServices collectionServices, ICollectionItemServices collectionItemServices, ICollectionItemSharedServices collectionItemSharedServices)
        {
            _userServices = userServices;
            _bannerServices = bannerServices;
            _collectionServices = collectionServices;
            _collectionItemServices = collectionItemServices;
            _collectionItemSharedServices = collectionItemSharedServices;
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

            model.CollectionItemSharedModel = (await _collectionItemSharedServices.GetCollectionItemSharedAsync(new Services.Model.CollectionItemSharedModel() { UserId = currentUser.Id })).ToList();

            var collectionItems = new List<CollectionItemModel>();
            var collectionFounded = new List<int>();

            foreach (var collection in collections)
            {
                collectionItems = (await _collectionItemServices.GetCollectionItemAsync(collection.Id, null)).ToList();

                foreach (var item in collectionItems)
                {
                    var colecaoCorrespondente = model.CollectionItemSharedModel.FirstOrDefault(c => c.CollectionItemId == item.Id);
                    if (colecaoCorrespondente != null && !collectionFounded.Contains(colecaoCorrespondente.CollectionItemId.Value))
                    {
                        collectionFounded.Add(colecaoCorrespondente.CollectionItemId.Value);
                    }
                }

                foreach (var item in collectionItems.Where(x => collectionFounded.Contains(x.Id)))
                {
                    var collectionItem = collectionItems.Where(x => x.CollectionItemTypeId == (int)CollectionItemType.MiniImage).FirstOrDefault();

                    if (model.CollectionsItemModel.Any(x => x.CollectionId == item.CollectionId))
                    {
                        continue;
                    }

                    model.CollectionsItemModel.Add(collectionItem);
                }
            }
            string pathView = string.Empty;

            return View(model);

        }
    }
}
