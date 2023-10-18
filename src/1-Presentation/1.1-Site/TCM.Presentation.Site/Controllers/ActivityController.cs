using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers
{
    public class ActivityController : Controller
    {
        private readonly IActivityUserServices _activityUserServices;
        private readonly ILogger<ActivityController> _logger;
        public ActivityController(IActivityUserServices activityUserServices, ILogger<ActivityController> logger)
        {
            _activityUserServices = activityUserServices;
            _logger = logger;
        }

        public async Task<IActionResult> FriendsActivities()
        {
            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2";

            var responseActivity = await _activityUserServices.GetActivityFriendUserAsync(Convert.ToInt32(id));
           
            HttpContext.Session.SetString("FriendsActivities", Newtonsoft.Json.JsonConvert.SerializeObject(responseActivity.OrderByDescending(a => a.ActivityDate)));

            TempData["FriendsActivities"] = Newtonsoft.Json.JsonConvert.DeserializeObject<List<ActivityUserModel>>(HttpContext.Session.GetString("FriendsActivities"));


            return View();
        }
    }
}
