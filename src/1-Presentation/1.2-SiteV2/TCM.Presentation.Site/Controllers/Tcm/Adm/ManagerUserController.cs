using Microsoft.AspNetCore.Mvc;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model.Enum;
using TCM.Services.Model;
using System.Threading.Tasks;

namespace TCM.Presentation.Site.Controllers.Tcm.Adm
{
    public class ManagerUserController : Controller
    {
        private readonly IUserServices _userServices;

        public ManagerUserController(IUserServices userServices)
        {
            _userServices = userServices;
        }

        public async Task<IActionResult> Adm()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var users = await _userServices.GetAllUsersAsync(new UserModel() { ProfileId = UserType.User });

            return View(users);
        }

        [HttpPost]
        public async Task<IActionResult> DisabledUser(int userId)
        {
            var id = await _userServices.UpdateUserEnabledAsync(userId, 0);

            if (id == 0)
            {
                return Json(new { IsOK = false, Errors = "Error desactived user " });
            }
            else
            {
                return Json(new { IsOK = true, Data = "User disable Successfuly", Redirect = "/ManagerUser/Adm" });
            }
        }

        [HttpPost]
        public async Task<IActionResult> EnabledUser(int userId)
        {
            var id = await _userServices.UpdateUserEnabledAsync(userId, 1);

            if (id == 0)
            {
                return Json(new { IsOK = false, Errors = "Error desactived user " });
            }
            else
            {
                return Json(new { IsOK = true, Data = "User enable Successfuly", Redirect = "/ManagerUser/Adm" });
            }
        }
    }
}
