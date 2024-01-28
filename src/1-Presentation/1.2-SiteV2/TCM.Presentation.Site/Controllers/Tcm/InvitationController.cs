using Microsoft.AspNetCore.Mvc;
using System;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using TCM.Services.Model.Enum;
using TCM.Services.Services;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class InvitationController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly IConnectionServices _connectionServices;
        public InvitationController(IUserServices userServices, IConnectionServices connectionServices)
        {
            _userServices = userServices;
            _connectionServices = connectionServices;
        }


        public async Task<IActionResult> Index()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            ViewBag.User = currentUser;

            var connections = await _connectionServices.ListConnectionsByConnectionUserIdAsync(currentUser.Id);

            connections = connections.Where(x => x.ConnectionStatusId == (int)ConnectionStatusType.Pending ||
            x.ConnectionStatusId == (int)ConnectionStatusType.Requested).ToList();

            return View(connections);
        }

        public async Task<IActionResult> Add(int connectionUserId)
        {
            var currentUser = _userServices.CurrentUserAsync();

            var resultAdd = await _connectionServices.AddConnectionAsync(currentUser.Id, connectionUserId);

            var user = await _userServices.GetUserAsync(new UserModel() { Id = connectionUserId });

            return RedirectToAction("SearchUser", "Search", new { username = user.FirstOrDefault().UserName });
        }
    }
}
