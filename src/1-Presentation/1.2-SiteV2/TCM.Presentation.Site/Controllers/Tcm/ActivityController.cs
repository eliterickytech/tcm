using Microsoft.AspNetCore.Mvc;
using System.Net;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class ActivityController : Controller
    {
        private readonly IActivityUserService _activityUserService;
        private readonly IUserServices _userServices;

        public ActivityController(IActivityUserService activityUserService, IUserServices userServices)
        {
            _activityUserService = activityUserService;
            _userServices = userServices;
        }

        public async Task<IActionResult> Index()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var activities = await _activityUserService.GetActivityFriendUserAsync(currentUser.Id);

            return View(activities);
        }
        public async Task<JsonResult> AddActivity([FromBody] ActivityUserModel model)
        {
            var activity = await _activityUserService.InsertActivityUserAsync(model.UserId, model.ActionDescription);

            return new JsonResult(new ResultModel()
            {
                StatusCode = activity > 0 ? HttpStatusCode.OK : HttpStatusCode.BadRequest,
                IsOK = activity > 0 ? true : false,
                Data = "Activity add successfuly",
                Redirect = "/Activity/Index"
            });

        }
        [HttpPost]
        public async Task<JsonResult> AddActivityIteration([FromBody] ActivityUserIterationViewModel activityUserIterationViewModel)
        {
            var activity = await _activityUserService.InsertActivityUserIterationAsync(activityUserIterationViewModel.UserId, activityUserIterationViewModel.ActivityId, 1);

            return new JsonResult(new ResultModel()
            {
                StatusCode = activity > 0 ? HttpStatusCode.OK : HttpStatusCode.BadRequest,
                IsOK = activity > 0 ? true : false,
                Redirect = "/Activity/Index"
            });
        }

        [HttpPost]
        public async Task<JsonResult> DeleteActivityIteration([FromBody] ActivityUserIterationViewModel activityUserIterationViewModel)
        {
            var activity = await _activityUserService.DeleteActivityUserIterationAsync(activityUserIterationViewModel.UserId, activityUserIterationViewModel.ActivityId, 1);

            return new JsonResult(new ResultModel()
            {
                StatusCode = activity > 0 ? HttpStatusCode.OK : HttpStatusCode.BadRequest,
                IsOK = activity > 0 ? true : false,
            });
        }

        [HttpGet]
        public async Task<JsonResult> CountActivityIteration(int activityId)
        {
            var activity = await _activityUserService.CountActivityUserIterationAsync(activityId);

            return new JsonResult(new ResultModel()
            {
                StatusCode = HttpStatusCode.OK ,
                IsOK = true,
                Data = activity
            });
        }
    }
}
