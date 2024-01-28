using Microsoft.AspNetCore.Mvc;
using System.Linq;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model.Enum;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class ConnectionBlockedController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly IConnectionServices _connectionServices;
        private readonly IActivityUserServices _activityUserServices;

        public ConnectionBlockedController(IActivityUserServices activityUserServices, IConnectionServices connectionServices, IUserServices userServices)
        {
            _activityUserServices = activityUserServices;
            _connectionServices = connectionServices;
            _userServices = userServices;
        }

        public async Task<IActionResult> Index()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var connectionsBlocked = await _connectionServices.GetConnectionBlockedAsync(currentUser.Id, null);

            var connections = await _connectionServices.ListConnectionsByConnectionUserIdAsync(currentUser.Id);

            connections = connections.Where(x => connectionsBlocked.Any(c => c == x.UserId) && x.ConnectionStatusId == (int)ConnectionStatusType.Blocked).ToList();



            return View(connections);
        }
    }
}
