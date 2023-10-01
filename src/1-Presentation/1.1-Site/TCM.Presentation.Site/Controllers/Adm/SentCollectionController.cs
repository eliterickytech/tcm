using Microsoft.AspNetCore.Mvc;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Runtime.CompilerServices;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using static Microsoft.ApplicationInsights.MetricDimensionNames.TelemetryContext;

namespace TCM.Presentation.Site.Controllers.Adm
{
    public class SentCollectionController : Controller
    {
        private readonly ICollectionServices _collectionServices;
        private readonly IUserServices _userServices;
        private readonly ICollectionItemServices _itemServices;
        private readonly CrossCutting.Helpers.Utils _utils;
        private readonly ICollectionItemUserServices _itemUserServices;
        private readonly ICollectionItemSharedServices _sharedServices;

        public SentCollectionController(ICollectionServices collectionServices, IUserServices userServices, ICollectionItemServices itemServices, CrossCutting.Helpers.Utils utils, ICollectionItemUserServices itemUserServices, ICollectionItemSharedServices sharedServices)
        {
            _collectionServices = collectionServices;
            _userServices = userServices;
            _itemServices = itemServices;
            _utils = utils;
            _itemUserServices = itemUserServices;
            _sharedServices = sharedServices;
        }

        public async Task<IActionResult> Index()
        {
            TempData["CountCollection"] = await GetCountCollectionAsync();
            TempData["Id"] = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2";

            return View();
        }
        private async Task<int> GetCountCollectionAsync()
        {
            return (await _collectionServices.GetCollectionAsync()).Count();
        }
        [HttpGet]
        public async Task<IActionResult> ListUsers(string q)
        {
            var users = await _userServices.GetUserAsync(new Services.Model.UserModel() { UserName = q });
            var results = new List<Results>();
            var select = new SelectUserModel();

            foreach (var user in users)
            {
                var result = new Results();
                result.id = user.Id.Value;
                result.text = user.UserName;

                results.Add(result);
            }

            select.results = results;
            select.pagination = new Pagination() { more = true };
            return Json(select);
        }

        public async Task<IActionResult> SentCollection()
        {
            var users = await _userServices.ListUserAsync();

            var collectionId = await _collectionServices.GetCollectionAsync();

            var countUsersForSent = Convert.ToInt32((users.Count() * 20) / 100);


            for (int i = 0; i < countUsersForSent; i++)
            {
                var collectionIdRandom = _utils.Randomize(collectionId.Select(x => x.Id).ToList()).FirstOrDefault();

                var collectionItem = await _itemServices.GetCollectionItemAsync(collectionIdRandom);
                var collectionItemRandom = _utils.Randomize(collectionItem.Select(x => x.Id).ToList()).FirstOrDefault();
                var usersIdRandom = _utils.Randomize(users.Where(x => x.Id > 1).ToList().Select(x => x.Id.Value).ToList()).FirstOrDefault();

                var insertedCollectionItemUser = await _itemUserServices.InsertCollectionItemUserAsync(
                    collectionIdRandom,
                    collectionItemRandom,
                    usersIdRandom
                    );

                var insertedShared = await _sharedServices.InsertCollectionItemSharedAsync(new Services.Model.CollectionItemSharedModel()
                {
                    CollectionItemId = collectionItemRandom,
                    UserId = usersIdRandom,
                    ConnectionUserId = 1,
                });
            }

            return Json(new { StatusCode = System.Net.HttpStatusCode.OK, IsOK = true, Data = countUsersForSent, Redirect = "" });

        }
    }
}
