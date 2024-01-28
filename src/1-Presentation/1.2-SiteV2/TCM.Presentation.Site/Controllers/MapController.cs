using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using TCM.Presentation.Site.Models;

namespace TCM.Presentation.Site.Controllers
{
    public class MapController : Controller
    {

        public IActionResult Vector()
        {
            return View();
        }
        
        public IActionResult Google()
        {
            return View();
        }
    }
}
