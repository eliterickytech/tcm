using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;

namespace TCM.Presentation.Controllers
{
	public class HomeController : Controller
	{
		private readonly ILogger<HomeController> _logger;
		private readonly IBannerServices _bannerServices;

		public HomeController(ILogger<HomeController> logger, 
			IBannerServices bannerServices)
		{
			_logger = logger;
			_bannerServices = bannerServices;
		}

		public async Task<IActionResult> Index()
		{
			HomeViewModel model = new HomeViewModel();
			var banners = await _bannerServices.GetBannerAsync();
            model.BannersModel = banners.ToList();
			return View(model);
		}

		public IActionResult Privacy()
		{
			return View();
		}

	}
}
