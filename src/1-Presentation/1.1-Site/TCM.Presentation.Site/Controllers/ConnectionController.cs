using Microsoft.AspNetCore.Mvc;
using System.Threading.Tasks;

namespace TCM.Presentation.Site.Controllers
{
    public class ConnectionController : Controller
    {
        public IActionResult Index()
        {
            return View();
        }

    }
}
