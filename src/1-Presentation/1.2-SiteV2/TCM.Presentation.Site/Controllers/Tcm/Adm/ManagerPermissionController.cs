using Microsoft.AspNetCore.Mvc;
using System.Linq;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Services;

namespace TCM.Presentation.Site.Controllers.Tcm.Adm
{
    public class ManagerPermissionController : Controller
    {
        private readonly IUserServices _userServices;

        public ManagerPermissionController(IUserServices userServices)
        {
            _userServices = userServices;
        }

        public IActionResult Adm()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            return View();
        }

        [HttpPost]
        public async Task<IActionResult> Update([FromBody] PermissionViewModel model)
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            if (model.Email != model.ConfirmEmail)
            {
                return Json(new { Errors = "Emails do not match", IsOK = false, StatusCode = System.Net.HttpStatusCode.InternalServerError });
            }

            if (await ValidatePassword(model.UserId, model.Password))
            {
                return Json(new { Errors = "Pin Invalid", IsOK = false, StatusCode = System.Net.HttpStatusCode.InternalServerError });
            }

            var user = await _userServices.GetUserAsync(new Services.Model.UserModel() { Email = model.Email });

            if (!user.Any())
            {
                return Json(new { Errors = "This email does not exist in the database", IsOK = false, StatusCode = System.Net.HttpStatusCode.InternalServerError });
            }

            var result = await _userServices.AddAdmAsync(user.FirstOrDefault().Id.Value);

            return Json(new { StatusCode = System.Net.HttpStatusCode.OK, IsOK = true, Data = "The change to admin has been changed successfully, please log in again to the new profile", Redirect = "/Login/Logoff"});
            
        }

            private async Task<bool> ValidatePassword(int userId, string password)
            {
                var user = await _userServices.GetUserAsync(new Services.Model.UserModel() { Id = userId, Password = password });
                return !user.Any();    
            }
    }
}
