using Microsoft.AspNetCore.Mvc;
using TCM.Services.Interfaces.Services;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class HomeController : Controller
    {
        private readonly IUserServices _userServices;

        public HomeController(IUserServices userServices)
        {
            _userServices = userServices;
        }

        public IActionResult Index()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            return View();
        }
    }
}
