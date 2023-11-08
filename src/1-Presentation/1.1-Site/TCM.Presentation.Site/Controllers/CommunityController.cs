using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using Serilog.Core;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using TCM.Services.Model.Enum;

namespace TCM.Presentation.Site.Controllers
{
    public class CommunityController : Controller
    {
        private readonly ILogger<CommunityController> _logger;
        private readonly IBannerServices _bannerServices;
        private readonly ICollectionServices _collectionServices;
        private readonly ICollectionItemServices _collectionItemServices;
        private readonly IUserServices _userServices;
        private readonly IChatServices _chatServices;
        private readonly IActivityUserServices _activityUserServices;

        private string id = string.Empty;

        public CommunityController(ILogger<CommunityController> logger,
            IBannerServices bannerServices,
            ICollectionServices collectionServices,
            ICollectionItemServices collectionItemServices,
            IUserServices userServices,
            IChatServices chatServices,
            IActivityUserServices activityUserServices)
        {
            _logger = logger;
            _bannerServices = bannerServices;
            _collectionServices = collectionServices;
            _collectionItemServices = collectionItemServices;
            _userServices = userServices;
            _chatServices = chatServices;
            _activityUserServices = activityUserServices;
        }
        public async Task<IActionResult> Index()
        {
            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2";

            CommunityModel model = new CommunityModel();

            var banners = await _bannerServices.GetBannerAsync();

            model.BannersModel = banners.ToList();

            var collections = await _collectionServices.GetCollectionAsync();

            model.CollectionsModel = collections.ToList();

            foreach (var collection in collections)
            {
                var collectionItems = await _collectionItemServices.GetCollectionItemAsync(collection.Id);

                var collectionItem = collectionItems.Where(x => x.CollectionItemTypeId == (int)CollectionItemType.MiniImage).FirstOrDefault();

                model.CollectionsItemModel.Add(collectionItem);
            }


            var responses = await ChatsUnread();

            model.CountUnreadChats = responses;

         

            TempData["ChatsUnread"] = model.CountUnreadChats;


                  var responseUserActivity = await _activityUserServices.GetActivityFriendUserAsync(Convert.ToInt32(id));
            //       HttpContext.Session.SetString("FriendsActivities", Newtonsoft.Json.JsonConvert.SerializeObject(responseUserActivity.OrderByDescending(a => a.ActivityDate)));
        //    var responseUserActivity = new List<ActivityUserModel>
        //    {
        //        new ActivityUserModel{ ActivityDate = DateTime.Now ,ActivityDescription = "Just shared " ,ProfileId = 2,UserName = "Ricardo", UserId = 2}
        //    };

        
            HttpContext.Session.SetString("FriendsActivities", Newtonsoft.Json.JsonConvert.SerializeObject(responseUserActivity));

               TempData["FriendsActivities"] = Newtonsoft.Json.JsonConvert.DeserializeObject<List<ActivityModel>>(HttpContext.Session.GetString("FriendsActivities"));



            return View(model);
        }

        public async Task<IActionResult> Adm()
        {
            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2";

            CommunityModel model = new CommunityModel();

            var banners = await _bannerServices.GetBannerAsync();

            model.BannersModel = banners.ToList();

            var collections = await _collectionServices.GetCollectionAsync();

            model.CollectionsModel = collections.ToList();

            foreach (var collection in collections)
            {
                var collectionItems = await _collectionItemServices.GetCollectionItemAsync(collection.Id);

                var collectionItem = collectionItems.Where(x => x.CollectionItemTypeId == (int)CollectionItemType.MiniImage).FirstOrDefault();

                model.CollectionsItemModel.Add(collectionItem);
            }


            var responses = await ChatsUnread();

            model.CountUnreadChats = responses;



            TempData["ChatsUnread"] = model.CountUnreadChats;


            var responseUserActivity = await _activityUserServices.GetActivityFriendUserAsync(Convert.ToInt32(id));
            //       HttpContext.Session.SetString("FriendsActivities", Newtonsoft.Json.JsonConvert.SerializeObject(responseUserActivity.OrderByDescending(a => a.ActivityDate)));
            //    var responseUserActivity = new List<ActivityUserModel>
            //    {
            //        new ActivityUserModel{ ActivityDate = DateTime.Now ,ActivityDescription = "Just shared " ,ProfileId = 2,UserName = "Ricardo", UserId = 2}
            //    };


            HttpContext.Session.SetString("FriendsActivities", Newtonsoft.Json.JsonConvert.SerializeObject(responseUserActivity));

            TempData["FriendsActivities"] = Newtonsoft.Json.JsonConvert.DeserializeObject<List<ActivityModel>>(HttpContext.Session.GetString("FriendsActivities"));



            return View(model);
        }

        private async Task<int> ChatsUnread()
        {
            id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2";

            var resultConnection = (await _chatServices.GetChatAsync(new Services.Model.ChatModel() { ChatConnectionUserId = Convert.ToInt32(id) }))
                .Where(chat => chat.ChatIsRead == false)
                .ToList();

           
            return resultConnection.Count;
        }

    }
}
