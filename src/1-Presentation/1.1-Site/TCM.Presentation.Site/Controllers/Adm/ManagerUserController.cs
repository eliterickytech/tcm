﻿using Microsoft.AspNetCore.Http;
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

namespace TCM.Presentation.Site.Controllers.Adm
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
            var users = await _userServices.GetUserAsync(new UserModel() { ProfileId = UserType.Administrative });
            TempData["Users"] = users;
            return View("~/Views/ManagerUser/Adm.cshtml");
        }

        public async Task<IActionResult> GetAllUsers()
        {
            var users = await _userServices.GetAllUsersAsync(new UserModel() { Enabled = true });
            TempData["Users"] = users;
            return View("~/Views/ManagerUser/Users.cshtml");
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
                return Json(new { IsOK = true, Data = "Operation Successfuly" });
            }
        }

        public async Task<IActionResult> SearchUser(string email)
        {
            var result = (await _userServices.GetUserAsync(new UserModel() { Email = email })).FirstOrDefault(x => x.ProfileId == UserType.User);

            if (result == null)
            {
                return Json(new { Errors = "User Invalid", IsOK = false, StatusCode = System.Net.HttpStatusCode.InternalServerError });
            }
            else
            {
                return Json(new { result.Id, IsOK = true, StatusCode = System.Net.HttpStatusCode.OK });
            }
        }
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> ProcessForm(int userid, string password)
        {

            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;

            if (!await ValidatePassword(Convert.ToInt32(id), password))
            {
                return Json(new { Errors = "Password Invalid", IsOK = false, StatusCode = System.Net.HttpStatusCode.InternalServerError });
            }

            var result = await _userServices.AddAdmAsync(userid);

            return Json(new { StatusCode = System.Net.HttpStatusCode.OK, IsOK = true, Data = "Added successfully", Redirect = "/ManagerUser/Adm" });
        }

        private async Task<bool> ValidatePassword(int userId, string password)
        {
            var user = await _userServices.GetUserAsync(new UserModel() { Id = userId, Password = password });

            return !(user.Count() == 0);
        }
    }
}
