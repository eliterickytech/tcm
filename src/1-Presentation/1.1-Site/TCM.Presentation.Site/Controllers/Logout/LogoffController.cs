using Microsoft.AspNetCore.Mvc;

namespace TCM.Presentation.Site.Controllers.Logout
{
    public class LogoffController : Controller
    {
        public IActionResult Index()
        {
            HttpContext.Session.Clear();
            return RedirectToAction("Index", "Login");
        }
    }
}
