using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.Mvc;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using TCM.CrossCutting.Helpers;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers.Tcm.Adm
{
    public class SendDelightsController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly ICollectionServices _collectionServices;
        private readonly ICollectionItemServices _collectionItemServices;
        private readonly ICollectionItemSharedServices _collectionItemSharedServices;
        private readonly IWebHostEnvironment _webHostEnvironment;
        private readonly Utils _utils;
        private string root = string.Empty;

        public SendDelightsController(IUserServices userServices, ICollectionServices collectionServices, ICollectionItemServices collectionItemServices, IWebHostEnvironment webHostEnvironment, ICollectionItemSharedServices collectionItemSharedServices)
        {
            _userServices = userServices;
            _collectionServices = collectionServices;
            _collectionItemServices = collectionItemServices;
            _webHostEnvironment = webHostEnvironment;
            _collectionItemSharedServices = collectionItemSharedServices;
        }

        public async Task<IActionResult> Adm()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var collections = await _collectionServices.GetCollectionAsync();

            var collectionsItems = await _collectionItemServices.GetCollectionItemAsync();

            var model = new TCM.Presentation.Site.Models.HomeViewModel();

            model.CollectionsModel = collections.ToList();

            model.CollectionsItemModel = collectionsItems.ToList().OrderBy(x => x.Id).ThenBy(x => x.Sequence).ToList();

            model.UserModel = new Services.Model.UserModel() { Email = currentUser.Email, UserName = currentUser.UserName, Id = currentUser.Id } ;

            return View(model);
        }

        [HttpPost]
        public async Task<JsonResult> SaveSharedItem([FromBody] SendDelightsViewModel model)
        {

            var result = await _collectionItemSharedServices.InsertCollectionItemSharedAsync(new Services.Model.CollectionItemSharedModel()
            {
                CollectionItemId = model.CollectionItemId,
                ConnectionUserId = model.ConnectionUserId,
                UserId = model.UserId
            });

            return new JsonResult(new ResultModel()
            {
                StatusCode = result > 0 ? HttpStatusCode.OK : HttpStatusCode.BadRequest,
                IsOK = result > 0 ? true : false,
                Data = "Successfully shared item"
            });

        }
    }
}
