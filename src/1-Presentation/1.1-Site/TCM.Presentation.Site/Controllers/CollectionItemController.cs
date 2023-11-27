using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
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
        private readonly ICollectionItemSharedServices _collectionItemSharedServices;

        public CollectionItemController(ICollectionItemServices collectionItemServices, ICollectionServices collectionServices, ICollectionItemUserServices collectionUserServices, ICollectionItemSharedServices collectionItemSharedServices)
        {
            this._collectionItemServices = collectionItemServices;
            this._collectionServices = collectionServices;
            this._collectionUserServices = collectionUserServices;
            this._collectionItemSharedServices = collectionItemSharedServices;
        }
        //[Authorize]
        public async Task<IActionResult> Index(int id)
        {
            if (!User.Identity.IsAuthenticated) return RedirectToAction("Index", "Login");

            var collectionDetails = await Details(id);

            return View(collectionDetails);
        }
        //[Authorize]
        private async Task<CollectionDetails> Details(int itemId) 
        {

            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;

            var collections = await _collectionServices.GetCollectionAsync();

            var collectionItem = await _collectionItemServices.GetCollectionItemDetailsAsync(itemId);
            var collectionItemShared = await _collectionItemSharedServices.GetCollectionItemSharedAsync(new CollectionItemSharedModel() { CollectionItemId = itemId });
            return new CollectionDetails()
            {
                CollectionId = collectionItem.CollectionId, 
                CollectionItemDescription = collectionItem.Description,
                Id = collectionItem.Id,
                Quantity = collectionItemShared.Count(),
                UrlImage = collectionItem.Url,
                Height = collectionItem.CollectionItemTypeHeigh,
                Width = collectionItem.CollectionItemTypeWidth,
            };
        }
    }
}
