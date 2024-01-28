using Microsoft.AspNetCore.Mvc;
using System;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class ConfigurationController : Controller
    {
        private readonly IUserServices _userServices;

        public ConfigurationController(IUserServices userServices)
        {
            _userServices = userServices;
        }

        public async Task<IActionResult> Index()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var user = (await _userServices.GetUserAsync(new UserModel() { Id = currentUser.Id })).FirstOrDefault();

            return View(user);
        }

        [HttpPost]
        public async Task<JsonResult> Settings([FromBody] UserModel userModel)
        {
            if (userModel.Password != userModel.ConfirmPassword)
                return new JsonResult(new ResultModel()
                {
                    StatusCode = HttpStatusCode.BadRequest,
                    Errors = "PIN not equals",
                    Type = "Password",
                    IsOK = false
                });

            var result = await _userServices.ChangeUserAsync(userModel);

            return new JsonResult(new ResultModel()
            {
                StatusCode = result > 0 ? HttpStatusCode.OK : HttpStatusCode.BadRequest,
                IsOK = result > 0,
                Data = "User data has been changed successfully",
                Redirect = "/Home"
            });
        }
    }
}
