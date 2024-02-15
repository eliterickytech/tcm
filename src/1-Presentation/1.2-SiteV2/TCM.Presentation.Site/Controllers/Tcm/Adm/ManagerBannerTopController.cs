﻿using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model.Enum;
using TCM.Services.Model;
using Microsoft.AspNetCore.Http;
using System.IO;
using System.Security.Claims;
using System;
using TCM.Presentation.Site.Models;

namespace TCM.Presentation.Site.Controllers.Tcm.Adm
{
    public class ManagerBannerTopController : Controller
    {
        private readonly IBannerServices _bannerServices;
        private readonly IUserServices _userServices;
        private readonly IWebHostEnvironment _webHostEnvironment;
        private string root = string.Empty;

        public ManagerBannerTopController(IBannerServices bannerServices, IUserServices userServices, IWebHostEnvironment webHostEnvironment)
        {
            _bannerServices = bannerServices;
            _userServices = userServices;
            _webHostEnvironment = webHostEnvironment;
            root = _webHostEnvironment.ContentRootPath;
        }

        public async Task<IActionResult> Adm()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var banner = await GetBannerAsync(BannerType.Top);

            return View(banner);
        }

        private async Task<List<BannerModel>> GetBannerAsync(BannerType bannerType)
        {
            var banner = (await _bannerServices.GetBannerAsync()).Where(b => b.BannerTypeId == (int)bannerType).ToList();

            return banner;
        }

        private async Task<bool> ValidatePassword(int userId, string password)
        {
            var user = await _userServices.GetUserAsync(new Services.Model.UserModel() { Id = userId, Password = password });
            return user.Any();
        }

        [HttpPost]
        public async Task<JsonResult> ProcessForm(IFormFile imageUpload, string redirectTo, string password)
        {
            var currentUser = _userServices.CurrentUserAsync();

            string filePath = "";
            string bannerURL = "";

            if (!await ValidatePassword(currentUser.Id, password))
            {
                return Json(new { Errors = "Pin Invalid", IsOK = false, StatusCode = System.Net.HttpStatusCode.InternalServerError });
            }

            filePath = string.Concat(root, "/StaticFiles/tcm/img/banner/top/", imageUpload.FileName);
            bannerURL = string.Concat("img/banner/top/", imageUpload.FileName);

            using (var stream = new FileStream(filePath, FileMode.Create))
            {
                imageUpload.CopyTo(stream);
            }

            var result = await _bannerServices.AddBannerAsync(new BannerModel()
            {
                BannerRedirectTo = redirectTo,
                BannerUrl = bannerURL,
                BannerTypeId = (int)BannerType.Top

            });

            return Json(new { StatusCode = System.Net.HttpStatusCode.OK, IsOK = true, Data = "Added successfully", Redirect = "/ManagerBannerTop/Adm" });
        }
    }
}