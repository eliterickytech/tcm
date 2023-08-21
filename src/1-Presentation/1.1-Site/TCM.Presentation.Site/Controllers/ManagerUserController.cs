using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System.IO;
using System;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;
using System.Web.Helpers;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model.Enum;
using TCM.Services.Model;
using TCM.Services.Services;

namespace TCM.Presentation.Site.Controllers
{
    public class ManagerUserController : Controller
    {
        private readonly IUserServices _userServices;

        public ManagerUserController(IUserServices userServices)
        {
            _userServices = userServices;
        }
        [Route("ManagerUser/Adm")]
        public async Task<IActionResult> Adm()
        {
            var users = await _userServices.GetUserAsync(new Services.Model.UserModel() { ProfileId = Services.Model.Enum.UserType.Administrative });
            TempData["Users"] = users;
            return View("~/Views/ManagerUser/Adm.cshtml");
        }
        [HttpPost]
        public async Task<IActionResult> DeleteAdm(int userId) 
        {
            var id = await _userServices.DeleteUserAsync(userId);

            if (id == 0)
            {
                return Json(new { IsOK = false, Errors = "Error deleting user " });
            }
            else
            {
                return Json(new { IsOK = true, Data = "Operation Successfuly" });
            }
        }
        public async Task<IActionResult> SearchUser(string email)
        {
            var result = (await _userServices.GetUserAsync(new Services.Model.UserModel() { Email = email })).FirstOrDefault(x=> x.ProfileId == Services.Model.Enum.UserType.User);

            if (result == null)
            {
                return Json(new { Errors = "User Invalid", IsOK = false, StatusCode = System.Net.HttpStatusCode.InternalServerError });
            }
            else
            {
                return Json(new { Id = result.Id, IsOK = true, StatusCode = System.Net.HttpStatusCode.OK });
            }
        }
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> ProcessForm(int userid, string password)
        {

            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2";

            if (!await ValidatePassword(Convert.ToInt32(id), password))
            {
                return Json(new { Errors = "Password Invalid", IsOK = false, StatusCode = System.Net.HttpStatusCode.InternalServerError });
            }

            var result = await _userServices.AddAdmAsync(userid);

            return Json(new { StatusCode = System.Net.HttpStatusCode.OK, IsOK = true, Data = "Added successfully", Redirect = "/ManagerUser/Adm" });
        }

        private async Task<Boolean> ValidatePassword(int userId, string password)
        {
            var user = await _userServices.GetUserAsync(new UserModel() { Id = userId, Password = password });

            return !(user.Count() == 0);
        }
    }
}
