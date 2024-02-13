using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System;
using System.Globalization;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers.Tcm.Adm
{
    public class ManagerCollectionController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly ICollectionServices _collectionServices;
        private readonly ICollectionItemServices _collectionItemServices;

        public ManagerCollectionController(IUserServices userServices, ICollectionServices collectionServices, ICollectionItemServices collectionItemServices)
        {
            _userServices = userServices;
            _collectionServices = collectionServices;
            _collectionItemServices = collectionItemServices;
        }

        public async Task<IActionResult> Adm()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var collections = await _collectionServices.GetCollectionAsync();

            var collectionsItems = await _collectionItemServices.GetCollectionItemAsync();

            var model = new TCM.Presentation.Site.Models.HomeViewModel();

            model.CollectionsModel = collections.ToList();

            model.CollectionsItemModel = collectionsItems.ToList().OrderBy(x => x.Sort).ToList();

            return View(model);
        }

        public IActionResult AddNewCollection()
        {
            return View();
        }
        public IActionResult AddNewCollectionItem()
        {
            return View();
        }

        [HttpGet]
        public async Task<JsonResult> ListCollection()
        {
            var collections = await _collectionServices.GetCollectionAsync();

            return new JsonResult(new ResultModel()
            {
                StatusCode = HttpStatusCode.OK,
                IsOK = true,
                Data = collections.Select(x => x.CollectionName).ToList()
            });
        }

        [HttpGet]
        public async Task<JsonResult> DeleteCollection(int id)
        {
            var resultDelete = await _collectionServices.RemoveCollectionAsync(id);

            return new JsonResult(new ResultModel()
            {
                StatusCode = resultDelete > 0 ? HttpStatusCode.OK : HttpStatusCode.BadRequest,
                IsOK = resultDelete > 0 ? true : false,
                Data = "Collection deleted successfully!",
                Redirect = "/ManagerCollection/Adm"
            });
        }

        [HttpPost]
        public async Task<JsonResult> SaveNewCollection([FromBody] CollectionViewModel model)
        {
            var collectionTypeQuantity = model.CollectionType == 1 ? 1 : model.CollectionType == 2 ? 4 : 9;
            DateTime data;
            DateTime.TryParseExact(model.AvaiableAt, "MM/dd/yyyy HH:mm:ss", CultureInfo.InvariantCulture, DateTimeStyles.None, out data);
            var result = await _collectionServices.AddCollectionAsync(new CollectionModel()
            {
                AvailableDate = data,
                CollectionName = model.CollectionName,
                Description = model.CollectionDescription,
                CollectionTypeId = model.CollectionType,
                CollectionTypeQuantity = collectionTypeQuantity
            });

            return new JsonResult(new ResultModel()
            {
                StatusCode = result > 0 ? HttpStatusCode.OK : HttpStatusCode.BadRequest,
                IsOK = result > 0 ? true : false,
                Data = "Collection saved successfully!",
                Redirect = "/ManagerCollection/AddNewCollectionItem"
            });
        }
    }
}
