using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System;
using System.Globalization;
using System.IO;
using System.Linq;
using System.Net;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.CrossCutting.Helpers;
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
        private readonly IWebHostEnvironment _webHostEnvironment;
        private readonly Utils _utils;
        private string root = string.Empty;
        public ManagerCollectionController(IUserServices userServices, ICollectionServices collectionServices, ICollectionItemServices collectionItemServices, Utils utils, IWebHostEnvironment webHostEnvironment)
        {
            _userServices = userServices;
            _collectionServices = collectionServices;
            _collectionItemServices = collectionItemServices;
            _utils = utils;
            _webHostEnvironment = webHostEnvironment;
            root = _webHostEnvironment.ContentRootPath;
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

            return View(model);
        }

        public IActionResult AddNewCollection()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            return View();
        }
        public async Task<IActionResult> AddNewCollectionItem(int collectionId)
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var collection = await _collectionServices.GetCollectionByIdAsync(collectionId);

            return View(collection);
        }

        public async Task<IActionResult> AddNewCollectionItemSurprise(int collectionId) 
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var collection = await _collectionServices.GetCollectionByIdAsync(collectionId);

            return View(collection);
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
                CollectionDescription = model.CollectionDescription,
                CollectionTypeId = model.CollectionType,
                CollectionTypeQuantity = collectionTypeQuantity
            });

            return new JsonResult(new ResultModel()
            {
                StatusCode = result > 0 ? HttpStatusCode.OK : HttpStatusCode.BadRequest,
                IsOK = result > 0 ? true : false,
                Data = "Collection saved successfully!",
                Redirect = $"/ManagerCollection/AddNewCollectionItem?collectionId={result}"
            });
        }

        [HttpPost]
        public async Task<JsonResult> SaveCollectionItem([FromBody] CollectionItemModelView model)
        {
            foreach (var item in model.CollectionItems)
            {
                var result = await _collectionItemServices.AddCollectionItemAsync(new CollectionItemModel()
                {
                    CollectionId = model.CollectionId,
                    CollectionItemTypeId = item.CollectionItemTypeId,
                    CollectionItemName = item.Description,
                    Description = item.Description,
                    Sort = item.Sort,
                    Url = item.Url,
                    Sequence = item.Sequence
                });
            }


            return new JsonResult(new ResultModel()
            {
                StatusCode = HttpStatusCode.OK ,
                IsOK = true,
                Data = "Collection Item saved successfully!",
                Redirect = $"/ManagerCollection/AddNewCollectionItemSurprise?collectionId={model.CollectionId}"
            });
        }

        [HttpPost]
        public async Task<JsonResult> SaveCollectionItemSurprise([FromBody] CollectionItemModelView model)
        {
            foreach (var item in model.CollectionItems)
            {
                var result = await _collectionItemServices.AddCollectionItemAsync(new CollectionItemModel()
                {
                    CollectionId = model.CollectionId,
                    CollectionItemTypeId = item.CollectionItemTypeId,
                    CollectionItemName = item.Description,
                    Description = item.Description,
                    Sort = item.Sort,
                    Url = item.Url,
                    Sequence = item.Sequence
                });
            }


            return new JsonResult(new ResultModel()
            {
                StatusCode = HttpStatusCode.OK,
                IsOK = true,
                Data = "Collection Item Surprise saved successfully!",
                Redirect = $"/Home/Adm"
            });
        }

        [HttpPost]
        public async Task<IActionResult> ProcessForm(IFormFile imagemInput, int collectionId, int collectionTypeId, string collectionName)
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            try
            {
                var collection = await _collectionServices.GetCollectionByIdAsync(collectionId);

                var relativeFolder = $"/StaticFiles/tcm/img/collection/{collectionId.ToString().PadLeft(6, '0')}/";

                var folderCollection = string.Concat(root, relativeFolder);

                var fullnameOrigin = string.Concat(folderCollection, $"origin/", imagemInput.FileName);

                var fullnameResize = string.Concat(folderCollection, $"resize/", imagemInput.FileName);

                var relativeFileOrigin = string.Concat(relativeFolder, $"origin/", imagemInput.FileName);

                _utils.CreateStructureFolder(folderCollection, false);

                _utils.CreateStructureFolder(fullnameResize, true);

                _utils.CreateStructureFolder(string.Concat(folderCollection, $"origin/"), false);

                _utils.CreateStructureFolder(string.Concat(folderCollection, $"resize/"), false);

                using (var stream = new FileStream(fullnameOrigin, FileMode.Create))
                {
                    imagemInput.CopyTo(stream);
                }

                _utils.ResizeImage(fullnameOrigin, fullnameResize, 350, 350);

                var splits = _utils.SplitImage(fullnameResize, folderCollection, relativeFolder, collectionTypeId);

                var colletionsPassToAddModel = new ColletionsPassToAddModel();
                colletionsPassToAddModel.CollectionName = collectionName;
                colletionsPassToAddModel.CollectionId = collectionId;
                colletionsPassToAddModel.CollectionTypeId = collectionTypeId;
                colletionsPassToAddModel.Url = string.Concat(relativeFolder, $"origin/", imagemInput.FileName);
                colletionsPassToAddModel.CollectionDescription = collection.CollectionDescription;
                splits.ForEach(x =>
                {
                    colletionsPassToAddModel.SplitImages.Add(x);
                });


                return Json(new { StatusCode = System.Net.HttpStatusCode.OK, IsOK = true, Data = colletionsPassToAddModel, Redirect = "" });
            }
            catch (Exception ex)
            {
                return Json(new { StatusCode = System.Net.HttpStatusCode.InternalServerError, IsOK = false, Errors = $"Errors: {ex.Message}", Redirect = "" });

            }
        }

        [HttpPost]
        public async Task<IActionResult> ProcessFormSurprise(IFormFile imagemInput, int collectionId, int collectionTypeId, string collectionName)
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            try
            {
                var collection = await _collectionServices.GetCollectionByIdAsync(collectionId);

                var relativeFolder = $"/StaticFiles/tcm/video/collection/{collectionId.ToString().PadLeft(6, '0')}/";

                var folderCollection = string.Concat(root, relativeFolder);

                var fullnameOrigin = string.Concat(folderCollection, $"origin/", imagemInput.FileName);

                var relativeFileOrigin = string.Concat(relativeFolder, $"origin/", imagemInput.FileName);

                _utils.CreateStructureFolder(folderCollection, false);

                _utils.CreateStructureFolder(string.Concat(folderCollection, $"origin/"), false);

                using (var stream = new FileStream(fullnameOrigin, FileMode.Create))
                {
                    imagemInput.CopyTo(stream);
                }
                var splits = new System.Collections.Generic.List<string>();

                var colletionsPassToAddModel = new ColletionsPassToAddModel();
                colletionsPassToAddModel.CollectionName = collectionName;
                colletionsPassToAddModel.CollectionId = collectionId;
                colletionsPassToAddModel.CollectionTypeId = collectionTypeId;
                colletionsPassToAddModel.Url = string.Concat(relativeFolder, $"origin/", imagemInput.FileName);
                colletionsPassToAddModel.CollectionDescription = collection.CollectionDescription;
                splits.Add(colletionsPassToAddModel.Url);

                splits.ForEach(x =>
                {
                    colletionsPassToAddModel.SplitImages.Add(x);
                });


                return Json(new { StatusCode = System.Net.HttpStatusCode.OK, IsOK = true, Data = colletionsPassToAddModel, Redirect = "" });
            }
            catch (Exception ex)
            {
                return Json(new { StatusCode = System.Net.HttpStatusCode.InternalServerError, IsOK = false, Errors = $"Errors: {ex.Message}", Redirect = "" });

            }
        }

    }
}
