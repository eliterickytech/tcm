using Microsoft.AspNetCore.Mvc;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using TCM.CrossCutting.Helpers;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers
{

    public class InvitationController : Controller
    {

        private readonly IConnectionServices _connectionService;

        public InvitationController(IConnectionServices connectionService)
        {
            _connectionService = connectionService;
        }

        public IActionResult Index()
        {
            List<ConnectionModel> models = new List<ConnectionModel>();

            ViewBag.Connection = models;
            return View();
        }

        [HttpPost]
        public IActionResult Index([FromBody] List<ConnectionModel> models)
        {
            ViewBag.Connection = models;
            return View();
        }


    }
}
