using Microsoft.AspNetCore.Mvc;
using Microsoft.VisualBasic;
using System;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers
{
    public class CollectionItemController : Controller
    {
        private readonly ICollectionItemServices _collectionItemServices;
        private readonly ICollectionServices _collectionServices;
        private readonly ICollectionItemUserServices _collectionUserServices;

        public CollectionItemController(ICollectionItemServices collectionItemServices, ICollectionServices collectionServices, ICollectionItemUserServices collectionUserServices)
        {
            this._collectionItemServices = collectionItemServices;
            this._collectionServices = collectionServices;
            this._collectionUserServices = collectionUserServices;
        }

        public async Task<IActionResult> Index(int id)
        {
            var collectionDetails = await Details(id);

            return View(collectionDetails);
        }

        private async Task<CollectionDetails> Details(int itemId) 
        {

            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2";

            var collections = await _collectionServices.GetCollectionAsync();

            var collectionItem = await _collectionItemServices.GetCollectionItemDetailsAsync(itemId);

            return new CollectionDetails()
            {
                CollectionId = collectionItem.CollectionId,
                CollectionItemDescription = collectionItem.Description,
                Id = collectionItem.Id,
                Quantity = collectionItem.Quantity,
                UrlImage = collectionItem.Url,
                Height = collectionItem.CollectionItemTypeHeigh,
                Width = collectionItem.CollectionItemTypeWidth,
            };
        }
    }
}
