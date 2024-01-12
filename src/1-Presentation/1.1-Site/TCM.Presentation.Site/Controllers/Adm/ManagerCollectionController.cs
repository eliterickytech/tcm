using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System.IO;
using System;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model.Enum;
using TCM.Services.Model;
using TCM.Services.Services;
using Microsoft.AspNetCore.Hosting;
using SendGrid.SmtpApi;
using System.Web.Mvc;
using TCM.Presentation.Site.Models;
using System.Text.Json;
using System.Security.Cryptography.X509Certificates;
using System.Collections.Generic;
using System.Xml.Schema;
using System.Globalization;
using Microsoft.AspNetCore.Mvc.Filters;

namespace TCM.Presentation.Site.Controllers.Adm
{
    public class ManagerCollectionController : Controller
    {
        private readonly ICollectionServices _collectionServices;
        private readonly ICollectionItemServices _collectionItem;
        private readonly IWebHostEnvironment _webHostEnvironment;
        private readonly CrossCutting.Helpers.Utils _utils;
        private string root = string.Empty;
        private List<ColletionsPassToAddModel>  listCollectionsImage= null;

        public ManagerCollectionController(ICollectionServices collectionServices, IWebHostEnvironment webHostEnvironment, CrossCutting.Helpers.Utils utils, ICollectionItemServices collectionItem)
        {
            _collectionServices = collectionServices;
            _webHostEnvironment = webHostEnvironment;
            root = _webHostEnvironment.WebRootPath;
            _utils = utils;
            _collectionItem = collectionItem;
            listCollectionsImage = new List<ColletionsPassToAddModel>();
        }

        public async Task<ActionResult> AddCollection()
        {
            TempData["CountCollection"] = await GetCountCollectionAsync();
            TempData["Id"] = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;
            TempData["CollectionId"] = 0;
            TempData["CollectionItemCount"] = 0;
            return View();
        }

        public async Task<ActionResult> RemoveCollection()
        {
            TempData["CountCollection"] = await GetCountCollectionAsync();
            TempData["Id"] = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;
            return View();
        }

        private async Task<int> GetCountCollectionAsync()
        {
            return (await _collectionServices.GetCollectionAsync()).Count(); 
        }
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> ProcessNameCollection(string collectionName)
        {
            try
            {
                HttpContext.Session.SetString("collectionName", collectionName); 
                var collection = (await _collectionServices.GetCollectionAsync()).Where(x => x.Enabled == true).DistinctBy(x => x.CollectionName);

                return Ok();
            }
            catch(Exception ex)
            {
                throw;
            }
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> ProcessForm(IFormFile imagemInput, int collectiontypeid, string collectionName)
        {
            try
            {
                collectionName = HttpContext.Session.GetString("collectionName");

                var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;
                var collectionItemsCount = Convert.ToInt32(TempData["CollectionItemCount"])+1;


                var collectionId = Convert.ToInt32(TempData["CollectionId"]);

                collectionId = (await _collectionServices.AddCollectionAsync(new CollectionModel() { CollectionName = collectionName, CollectionTypeId = 1, IsPhysicalAward = false, AvailableDate = DateTime.Now }));

                var relativeFolder = $"/img/collection/{collectionId.ToString().PadLeft(6, '0')}/";

                var folderCollection = string.Concat(root, relativeFolder);

                var fullnameOrigin = string.Concat(folderCollection, $"{collectionItemsCount.ToString().PadLeft(6, '0')}_origin/", imagemInput.FileName);

                var fullnameResize = string.Concat(folderCollection, $"{collectionItemsCount.ToString().PadLeft(6, '0')}_resize/", imagemInput.FileName);

                var relativeFileOrigin = string.Concat(relativeFolder, $"{collectionItemsCount.ToString().PadLeft(6, '0')}_origin/", imagemInput.FileName);

                _utils.CreateStructureFolder(folderCollection, false);

                _utils.CreateStructureFolder(fullnameResize, true);

                _utils.CreateStructureFolder(string.Concat(folderCollection, $"{collectionItemsCount.ToString().PadLeft(6, '0')}_origin/"), false);

                _utils.CreateStructureFolder(string.Concat(folderCollection, $"{collectionItemsCount.ToString().PadLeft(6, '0')}_resize/"), false);

                using (var stream = new FileStream(fullnameOrigin, FileMode.Create))
                {
                    imagemInput.CopyTo(stream);
                }

                _utils.ResizeImage(fullnameOrigin, fullnameResize, 350, 350);

                var splits = _utils.SplitImage(fullnameResize, folderCollection, collectiontypeid, collectionItemsCount);               

                var colletionsPassToAddModel = new ColletionsPassToAddModel();
                colletionsPassToAddModel.CollectionName = collectionName;
                colletionsPassToAddModel.CollectionId = collectionId;
                colletionsPassToAddModel.CollectionTypeId = collectiontypeid;
                colletionsPassToAddModel.UrlResize = fullnameResize;

                splits.ForEach(x =>
                {
                    colletionsPassToAddModel.SplitImages.Add(x);
                });

                TempData["CollectionName"] = collectionName;
                TempData["CollectionTypeId"] = collectiontypeid;
                TempData["Splits"] = colletionsPassToAddModel.SplitImages;
                TempData["UrlResize"] = colletionsPassToAddModel.UrlResize;
                TempData["CollectionId"] = collectionId;
                TempData["CollectionItemCount"] = collectionItemsCount;
                return Json(new { StatusCode = System.Net.HttpStatusCode.OK, IsOK = true, Data = colletionsPassToAddModel, Redirect = "" });
            }
            catch(Exception ex)
            {
                return Json(new { StatusCode = System.Net.HttpStatusCode.InternalServerError, IsOK = false, Errors = $"Errors: {ex.Message}", Redirect = "" });

            }

            
        }
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> InsertCollection(
            string available,
            string scheduledDate,
            string miniature,
            string piece1,
            string piece2,
            string piece3,
            string piece4,
            string piece5,
            string piece6,
            string piece7,
            string piece8,
            string piece9,
            IFormFile fileInput,
            string videoDescription)
        {
            CultureInfo culture = new CultureInfo("pt-BR");
            var collectionTypeId = Convert.ToInt32(TempData["CollectionTypeId"]);
            var collectionId = Convert.ToInt32(TempData["CollectionId"]);
            var urlResize = TempData["UrlResize"].ToString();
            var splits = (string[])TempData["Splits"];
          
            var collectionName = HttpContext.Session.GetString("collectionName");

            var relativeFolder = $"/img/collection/{collectionId.ToString().PadLeft(6, '0')}/";
            if (fileInput != null)
            {
                var relativeVideoOrigin = string.Concat(root, relativeFolder, "video/", fileInput.FileName);

                _utils.CreateStructureFolder(string.Concat(root, relativeFolder, "video/"), false);

                _utils.CreateStructureFolder(string.Concat(root, relativeFolder, "video/"), false);

                using (var stream = new FileStream(relativeVideoOrigin, FileMode.Create))
                {
                    fileInput.CopyTo(stream);
                }
            }

            var resultUpdated = await _collectionServices.UpdateCollecitonAsync(new CollectionModel()
            {
                Id = collectionId,
                CollectionName = collectionName,
                CollectionTypeId = collectionTypeId,
                CollectionTypeQuantity = collectionTypeId == 1 ? 1 : collectionTypeId == 2 ? 4 : 9,
                AvailableDate = available == "1" ? DateTime.Now : Convert.ToDateTime(scheduledDate),
            });

            FileInfo fileInfo = new FileInfo(urlResize);
            var directoryBase = $"../../img/collection/{collectionId.ToString().PadLeft(6, '0')}/";

            if (resultUpdated > 0)
            {
                var insertedMiniatura = await _collectionItem.AddCollectionItemAsync(new CollectionItemModel()
                {
                    CollectionId = collectionId,
                    CollectionItemTypeId = (int)CollectionItemType.MiniImage,
                    Url = $"{directoryBase}resize/{fileInfo.Name}",
                    Sort = 0,
                    Description = miniature,
                    CollectionItemName = miniature,
                });

                var insertedBackground = await _collectionItem.AddCollectionItemAsync(new CollectionItemModel()
                {
                    CollectionId = collectionId,
                    CollectionItemTypeId = (int)CollectionItemType.BackgroundImage,
                    Url = $"{directoryBase}resize/{fileInfo.Name}",
                    Sort = 0,
                    Description = miniature,
                    CollectionItemName = miniature,
                });

                if (fileInput != null)
                {
                    var insertedVideo = await _collectionItem.AddCollectionItemAsync(new CollectionItemModel()
                    {
                        CollectionId = collectionId,
                        CollectionItemTypeId = (int)CollectionItemType.BackgroundImage,
                        Url = $"{directoryBase}video/{fileInput.FileName}",
                        Sort = 0,
                        Description = videoDescription,
                        CollectionItemName = videoDescription,
                    });
                }


                var descriptions = new List<string>();

                descriptions.Add(piece1);
                descriptions.Add(piece2);
                descriptions.Add(piece3);
                descriptions.Add(piece4);
                descriptions.Add(piece5);
                descriptions.Add(piece6);
                descriptions.Add(piece7);
                descriptions.Add(piece8);
                descriptions.Add(piece9);

                for (int i = 0; i < splits.Length; i++)
                {
                    var sort = i;
                    FileInfo fileInfoSplit = new FileInfo(splits[i]);
                    var collectionItem = new CollectionItemModel();
                    collectionItem.CollectionId = collectionId;
                    collectionItem.CollectionItemTypeId = collectionTypeId;
                    collectionItem.Url = $"{directoryBase}{fileInfoSplit.Name}";
                    collectionItem.Sort = (sort += 1);
                    collectionItem.Description = descriptions[i].ToString();
                    var insertedItems = await _collectionItem.AddCollectionItemAsync(collectionItem);


                }
            }

            TempData["CollectionId"] = collectionId;

          ;

            return Json(new { StatusCode = System.Net.HttpStatusCode.OK, IsOK = true, Data = true, Redirect = "" });
        }

        public async Task<IActionResult> RemovingCollection(int radioCollection)
        {
            await _collectionServices.RemoveCollectionAsync(radioCollection);
            return Json(new { StatusCode = System.Net.HttpStatusCode.OK, IsOK = true, Data = true, Redirect = "" });
        }

        private bool IsImageFile(string filePath)
        {
            string extension = Path.GetExtension(filePath);
            string[] imageExtensions = { ".jpg", ".jpeg", ".png", ".gif", ".bmp" }; // Adicione mais extensões, se necessário

            return imageExtensions.Contains(extension, StringComparer.OrdinalIgnoreCase);
        }
    }
}
