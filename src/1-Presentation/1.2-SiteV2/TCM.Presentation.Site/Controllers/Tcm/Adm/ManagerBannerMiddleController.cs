using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using TCM.Services.Model.Enum;

namespace TCM.Presentation.Site.Controllers.Tcm.Adm
{
    public class ManagerBannerMiddleController : Controller
    {
        private readonly IBannerServices _bannerServices;
        private readonly IUserServices _userServices;
        private readonly IWebHostEnvironment _webHostEnvironment;
        private string root = string.Empty;

        public ManagerBannerMiddleController(IWebHostEnvironment webHostEnvironment, IUserServices userServices, IBannerServices bannerServices)
        {
            _webHostEnvironment = webHostEnvironment;
            _userServices = userServices;
            _bannerServices = bannerServices;
            root = _webHostEnvironment.ContentRootPath;

        }

        public async Task<IActionResult> Adm()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var banner = await GetBannerAsync(BannerType.Middle);

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
        public async Task<JsonResult> ProcessForm(IFormFile imageUpload, string redirectTo, string password, bool video)
        {
            var currentUser = _userServices.CurrentUserAsync();

            string filePath = "";
            string bannerURL = "";

            if (!await ValidatePassword(currentUser.Id, password))
            {
                return Json(new { Errors = "Pin Invalid", IsOK = false, StatusCode = System.Net.HttpStatusCode.InternalServerError });
            }

            filePath = string.Concat(root, "/StaticFiles/tcm/img/banner/middle/", imageUpload.FileName);
            bannerURL = string.Concat("img/banner/middle/", imageUpload.FileName);

            using (var stream = new FileStream(filePath, FileMode.Create))
            {
                imageUpload.CopyTo(stream);
            }

            var result = await _bannerServices.AddBannerAsync(new BannerModel()
            {
                BannerRedirectTo = redirectTo,
                BannerUrl = bannerURL,
                BannerTypeId = (int)BannerType.Middle,
                BannerVideo = video

            });

            return Json(new { StatusCode = System.Net.HttpStatusCode.OK, IsOK = true, Data = "Added successfully", Redirect = "/ManagerBannerMiddle/Adm" });
        }
    }
}
