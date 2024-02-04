using Microsoft.AspNetCore.Mvc;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Services;

namespace TCM.Presentation.Site.Controllers.Tcm.Adm
{
    public class HomeController : Controller
    {
        private readonly IUserServices _userServices;

        public HomeController(IUserServices userServices)
        {
            _userServices = userServices;
        }

        public async Task<IActionResult> Adm()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            return View();
        }
    }
}
