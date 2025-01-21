using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;
using System;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using TCM.CrossCutting.Helpers;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using static Microsoft.ApplicationInsights.MetricDimensionNames.TelemetryContext;
using TCM.Services.Model.Enum;

namespace TCM.Presentation.Site.Controllers.Tcm.Adm
{
    public class SendDelightsController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly ICollectionServices _collectionServices;
        private readonly ICollectionItemServices _collectionItemServices;
        private readonly ICollectionItemSharedServices _collectionItemSharedServices;
        private readonly IWebHostEnvironment _webHostEnvironment;
        private readonly IChatServices _chatServices;
        private readonly IActivityUserServices _activityUserServices;
        private readonly Utils _utils;
        private string root = string.Empty;

        public SendDelightsController(IUserServices userServices, ICollectionServices collectionServices, ICollectionItemServices collectionItemServices, IWebHostEnvironment webHostEnvironment, ICollectionItemSharedServices collectionItemSharedServices, IChatServices chatServices, IActivityUserServices activityUserServices)
        {
            _userServices = userServices;
            _collectionServices = collectionServices;
            _collectionItemServices = collectionItemServices;
            _webHostEnvironment = webHostEnvironment;
            _collectionItemSharedServices = collectionItemSharedServices;
            _chatServices = chatServices;
            _activityUserServices = activityUserServices;
        }

        public async Task<IActionResult> Adm()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var collections = await _collectionServices.GetCollectionAdmAsync();

            var collectionsItems = await _collectionItemServices.GetCollectionAdmItemAsync();

            var model = new TCM.Presentation.Site.Models.HomeViewModel();

            model.CollectionsModel = collections.ToList();

            model.CollectionsItemModel = collectionsItems.ToList().OrderBy(x => x.Id).ThenBy(x => x.Sequence).ToList();

            model.UserModel = new Services.Model.UserModel() { Email = currentUser.Email, UserName = currentUser.UserName, Id = currentUser.Id } ;

            return View(model);
        }
        public async Task<IActionResult> ShareDelightConnection(int collectionItemId)
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var collectionItem = (await _collectionItemServices.GetCollectionItemAsync(null, collectionItemId)).FirstOrDefault();

            return View(collectionItem);
        }

        [HttpPost]
        public async Task<JsonResult> SaveSharedItem([FromBody] SendDelightsViewModel model)
        {
            var currentUser = _userServices.CurrentUserAsync();

            var result = await _collectionItemSharedServices.InsertCollectionItemSharedAsync(new Services.Model.CollectionItemSharedModel()
            {
                CollectionItemId = model.CollectionItemId,
                ConnectionUserId = model.ConnectionUserId,
                UserId = model.UserId
            });

            if (result is { })
            {
                var resultChat = await _chatServices.AddChatAsync(new Services.Model.ChatModel()
                {
                    ChatConnectionUserId = model.UserId,
                    ChatUserId = model.ConnectionUserId,
                    ChatMessage = model.Description ?? "I just shared an image with you, check it out in your collection",
                });
            }

            if (result is { } && (model.PostMyActivity || currentUser.ProfileId == (int) UserType.Administrative ))
            {
                UserModel connection = new UserModel();
                UserModel user = new UserModel();

                try
                {
                    user = (await _userServices.GetUserAsync(new UserModel() { Id = model.UserId })).FirstOrDefault();
                }
                catch(Exception ex)
                {
                    return new JsonResult(new ResultModel()
                    {
                        StatusCode = HttpStatusCode.BadRequest,
                        IsOK = false,
                        Data = ex.Message,
                    });
                }

                try
                {
                    connection = (await _userServices.GetUserAsync(new UserModel() { Id = model.ConnectionUserId })).FirstOrDefault();
                }
                catch(Exception ex)
                {
                    return new JsonResult(new ResultModel()
                    {
                        StatusCode = HttpStatusCode.BadRequest,
                        IsOK = false,
                        Data = ex.Message,
                    });
                }

                try
                {
                    var resultActivity = await _activityUserServices.InsertActivityUserAsync(model.ConnectionUserId, $"User {connection.UserName} has just shared an item with user {user.UserName}");
                }
                catch(Exception ex)
                {
                    return new JsonResult(new ResultModel()
                    {
                        StatusCode = HttpStatusCode.BadRequest,
                        IsOK = false,
                        Data = ex.Message,
                    });
                }
            }

            return new JsonResult(new ResultModel()
            {
                StatusCode = result > 0 ? HttpStatusCode.OK : HttpStatusCode.BadRequest,
                IsOK = result > 0 ? true : false,
                Data = "Successfully shared item",
                Redirect = "/SendDelights/Adm"
            });

        }

        [HttpPost]
        public async Task<JsonResult> SaveSharedUserItem([FromBody] SendDelightsViewModel model)
        {

            var result = await _collectionItemSharedServices.InsertCollectionItemSharedAsync(new Services.Model.CollectionItemSharedModel()
            {
                CollectionItemId = model.CollectionItemId,
                ConnectionUserId = model.ConnectionUserId,
                UserId = model.UserId
            });

            if (result is { })
            {
                var resultChat = await _chatServices.AddChatAsync(new Services.Model.ChatModel()
                {
                    ChatConnectionUserId = model.UserId,
                    ChatUserId = model.ConnectionUserId,
                    ChatMessage = model.Description ?? "I just shared an image with you, check it out in your collection",
                });
            }

            UserModel connection = new UserModel();
            UserModel user = new UserModel();

            if (result is { } && model.PostMyActivity)
            {
                try
                {
                    user = (await _userServices.GetUserAsync(new UserModel() { Id = model.UserId })).FirstOrDefault();
                }
                catch (Exception ex)
                {
                    return new JsonResult(new ResultModel()
                    {
                        StatusCode = HttpStatusCode.BadRequest,
                        IsOK = false,
                        Data = ex.Message,
                    });
                }

                try
                {
                    connection = (await _userServices.GetUserAsync(new UserModel() { Id = model.ConnectionUserId })).FirstOrDefault();
                }
                catch (Exception ex)
                {
                    return new JsonResult(new ResultModel()
                    {
                        StatusCode = HttpStatusCode.BadRequest,
                        IsOK = false,
                        Data = ex.Message,
                    });
                }

                try
                {
                    var resultActivity = await _activityUserServices.InsertActivityUserAsync(model.ConnectionUserId, $"User {connection.UserName} has just shared an item with user {user.UserName}");
                }
                catch (Exception ex)
                {
                    return new JsonResult(new ResultModel()
                    {
                        StatusCode = HttpStatusCode.BadRequest,
                        IsOK = false,
                        Data = ex.Message,
                    });
                }

            }
            return new JsonResult(new ResultModel()
            {
                StatusCode = result > 0 ? HttpStatusCode.OK : HttpStatusCode.BadRequest,
                IsOK = result > 0 ? true : false,
                Data = "Successfully shared item",
                Redirect = "/home"
            });

        }
        [HttpGet]
        public async Task<JsonResult> ListSharedItemsByCollectionItemId(int collectionItemId)
        {
            var currentUser = _userServices.CurrentUserAsync();

            var items = (await _collectionItemSharedServices.GetCollectionItemSharedAsync(new CollectionItemSharedModel() { CollectionItemId = collectionItemId,  UserId = currentUser.Id }));

            var connectionNameShared = (await _userServices.GetUserAsync(new UserModel() { Id = items.LastOrDefault().ConnectionUserId })).FirstOrDefault().UserName;

            var collectionItem = (await _collectionItemServices.GetCollectionItemAsync(null, collectionItemId)).FirstOrDefault();

            var quantityShared = items.Count();

            return new JsonResult(new ResultModel()
            {
                StatusCode = HttpStatusCode.OK,
                IsOK = true,
                Data = new SendDelightsViewModel()
                {
                    CollectionItemId = collectionItemId,
                    ConnectionUserId = items.LastOrDefault().ConnectionUserId ?? 0,
                    ConnectionNameShared  = connectionNameShared,
                    Quantity = quantityShared,
                    Url = collectionItem.Url,
                    Description = collectionItem.Description
                }
            });
        } 

        [HttpPost]
        public async Task<JsonResult> SaveSharedRandomItem([FromBody] SendDelightsViewModel model)
        {
            var users = await _userServices.GetUserAsync(new UserModel() { ProfileId = Services.Model.Enum.UserType.User });

            //var items = (await _collectionItemServices.GetCollectionItemAsync()).Where(x => x.CollectionItemTypeIsCollectible).ToList();

            var selectedUsers = SelectRandom(users.ToList(), 0.2);


            foreach (var user in selectedUsers)
            {
                //var selectedItems = model.CollectionItemId; /*SelectRandom(items, null).FirstOrDefault();*/

                var result = await _collectionItemSharedServices.InsertCollectionItemSharedAsync(new Services.Model.CollectionItemSharedModel()
                {
                    CollectionItemId = model.CollectionItemId,
                    ConnectionUserId = model.ConnectionUserId ,
                    UserId = user.Id
                });

                if (result is { })
                {
                    var resultChat = await _chatServices.AddChatAsync(new Services.Model.ChatModel()
                    {
                        ChatConnectionUserId = model.ConnectionUserId,
                        ChatUserId = user.Id,
                        ChatMessage = "I just shared an image with you, check it out in your collection",
                    });
                }

                if (result is { })
                {
                    var userLocal = (await _userServices.GetUserAsync(new UserModel() { Id = user.Id })).FirstOrDefault();

                    var connection = (await _userServices.GetUserAsync(new UserModel() { Id = model.ConnectionUserId })).FirstOrDefault();

                    var resultActivity = await _activityUserServices.InsertActivityUserAsync(model.ConnectionUserId, $"User {connection.UserName} has just shared an item with user {userLocal.UserName}");
                }
            }

            return new JsonResult(new ResultModel()
            {
                StatusCode = HttpStatusCode.OK,
                IsOK = true,
                Data = "Successfully shared item",
                Redirect = "/SendDelights/Adm"
            });
        }

        private List<T> SelectRandom<T>(List<T> list, double? proportion)
        {
            Random random = new Random();
            int quantity = proportion.HasValue ? (int)Math.Ceiling(list.Count * proportion.Value) : list.Count;
            return list.OrderBy(x => random.Next()).Take(quantity).ToList();
        }
    }
}
