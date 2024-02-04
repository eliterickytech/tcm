using Microsoft.AspNetCore.Hosting;
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
            root = _webHostEnvironment.WebRootPath;
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
            return !user.Any();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> ProcessForm(IFormFile imageUpload, string redirectTo, string password, BannerType bannertype)
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            string filePath = "";
            string bannerURL = "";

            var id = currentUser.Id;

            if (!await ValidatePassword(Convert.ToInt32(id), password))
            {
                return Json(new { Errors = "Pin Invalid", IsOK = false, StatusCode = System.Net.HttpStatusCode.InternalServerError });
            }

            if (bannertype == BannerType.Top)
            {
                filePath = string.Concat(root, "/img/banner/top/", imageUpload.FileName);
                bannerURL = string.Concat("img/banner/top/", imageUpload.FileName);
            }
            else
            {
                filePath = string.Concat(root, "/img/banner/middle/", imageUpload.FileName);
                bannerURL = string.Concat("img/banner/middle/", imageUpload.FileName);
            }

            using (var stream = new FileStream(filePath, FileMode.Create))
            {
                imageUpload.CopyTo(stream);
            }

            var result = await _bannerServices.AddBannerAsync(new BannerModel()
            {
                BannerRedirectTo = redirectTo,
                BannerTypeId = (int)bannertype,
                BannerUrl = bannerURL
            });

            return Json(new { StatusCode = System.Net.HttpStatusCode.OK, IsOK = true, Data = "Added successfully", Redirect = "/ManagerBannerTop/Adm" });
        }
    }
}
