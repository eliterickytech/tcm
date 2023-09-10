using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using TCM.Services.Model.Enum;

namespace TCM.Presentation.Site.Controllers.Adm
{
    public class BannerController : Controller
    {
        private readonly IBannerServices _bannerServices;
        private readonly IUserServices _userServices;
        private readonly IWebHostEnvironment _webHostEnvironment;
        private string root = string.Empty;

        public BannerController(IBannerServices bannerServices, IUserServices userServices, IWebHostEnvironment webHostEnvironment)
        {
            _bannerServices = bannerServices;
            _userServices = userServices;
            _webHostEnvironment = webHostEnvironment;
            root = _webHostEnvironment.WebRootPath;
        }

        public async Task<IActionResult> Adm()
        {
            var bannerTop = await GetBannerAsync(BannerType.Top);
            TempData["BannerTop"] = bannerTop;
            return View();
        }

        public async Task<IActionResult> AdmRequest([FromQuery] int bannerTypeId)
        {
            BannerType bannerType = (BannerType)bannerTypeId;

            if (bannerType == BannerType.Top)
            {
                TempData["BannerMiddle"] = null;
                var bannerTop = await GetBannerAsync(bannerType);
                TempData["BannerTop"] = bannerTop;
            }
            else
            {
                TempData["BannerTop"] = null;
                var bannerMiddle = await GetBannerAsync(bannerType);
                TempData["BannerMiddle"] = bannerMiddle;
            }

            return View("~/Views/Banner/Adm.cshtml");
        }


        [Route("Adm/BannerMiddle")]
        public async Task<IActionResult> BannerMiddle()
        {

            return View();
        }

        private async Task<List<BannerModel>> GetBannerAsync(BannerType bannerType)
        {
            var banner = (await _bannerServices.GetBannerAsync()).Where(b => b.BannerTypeId == (int)bannerType).ToList();

            return banner;
        }
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> ProcessForm(IFormFile imageUpload, string redirectTo, string password, BannerType bannertype)
        {
            string filePath = "";
            string bannerURL = "";

            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2";

            if (!await ValidatePassword(Convert.ToInt32(id), password))
            {
                return Json(new { Errors = "Password Invalid", IsOK = false, StatusCode = System.Net.HttpStatusCode.InternalServerError });
            }

            if (bannertype == BannerType.Top)
            {
                filePath = string.Concat(root, "/img/banner/top/", imageUpload.FileName);
                bannerURL = string.Concat("../../img/banner/top/", imageUpload.FileName);
            }
            else
            {
                filePath = string.Concat(root, "/img/banner/middle/", imageUpload.FileName);
                bannerURL = string.Concat("../../img/banner/middle/", imageUpload.FileName);
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

            return Json(new { StatusCode = System.Net.HttpStatusCode.OK, IsOK = true, Data = "Added successfully", Redirect = "/Banner/Adm" });
        }

        private async Task<bool> ValidatePassword(int userId, string password)
        {
            var user = await _userServices.GetUserAsync(new UserModel() { Id = userId, Password = password });

            return !(user.Count() == 0);
        }
    }
}
