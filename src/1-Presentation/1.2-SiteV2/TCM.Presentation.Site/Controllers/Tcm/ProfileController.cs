using Microsoft.AspNetCore.Mvc;
using System.Linq;
using System;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using TCM.Services.Services;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Model.Enum;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class ProfileController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly IChatServices _chatServices;
        private readonly IConnectionServices _connectionServices;
        private readonly ICollectionItemServices _collectionItemServices;
        private readonly ICollectionServices _collectionServices;

        public ProfileController(IUserServices userServices, IChatServices chatServices, IConnectionServices connectionServices, ICollectionServices collectionServices)
        {
            _userServices = userServices;
            _chatServices = chatServices;
            _connectionServices = connectionServices;
            _collectionServices = collectionServices;
        }


        public IActionResult Index(int connectionUserId)
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            ViewBag.ConnectionUserId = connectionUserId;

            return View();
        }

        public IActionResult ProfileConnection(int connectionUserId)
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            return RedirectToAction("Index", new { connectionUserId = connectionUserId });

        }
    }
}
