using Microsoft.AspNetCore.Mvc;
using System.Linq;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using TCM.Services.Model.Enum;
using TCM.Services.Services;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class ConnectionController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly IConnectionServices _connectionServices;
        private readonly IActivityUserServices _activityUserServices;

        public ConnectionController(IUserServices userServices, IConnectionServices connectionServices, IActivityUserServices activityUserServices)
        {
            _userServices = userServices;
            _connectionServices = connectionServices;
            _activityUserServices = activityUserServices;
        }

        public async Task< IActionResult> Index()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            ViewBag.User = currentUser;

            var connectionsYou = await _connectionServices.ListConnectionsByConnectionUserIdAsync(currentUser.Id);

            var connectionMe = await _connectionServices.ListConnectionsByUserIdAsync(currentUser.Id);

            var connectionAll = connectionsYou.Concat(connectionMe).ToList();

            connectionAll = connectionAll.Where(x => x.ConnectionStatusId == (int)ConnectionStatusType.Approved).ToList();

            return View(connectionAll);
        }

        public async Task<IActionResult> UpdateStatusConnection(int id, ConnectionStatusType connectionStatusType)
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            if (connectionStatusType == ConnectionStatusType.Canceled)
            {
                await _connectionServices.DeleteConnectionAsync(id, (int)connectionStatusType);
            }
            else if (connectionStatusType == ConnectionStatusType.Blocked || connectionStatusType == ConnectionStatusType.Approved)
            {
                ConnectionModel connectionModel = new ConnectionModel();

                connectionModel.ConnectionUserId = id;

                var t = await _connectionServices.UpdateStatusConnectionAsync(id, (int)connectionStatusType);

                if (t >= 1 && connectionStatusType == ConnectionStatusType.Approved)
                {
                    var resultConnections = await _connectionServices.GetConnectionAsync(new ConnectionModel() { ConnectionUserId = currentUser.Id });

                    var connection = resultConnections.Where(c => c.ConnectionUserId == id).FirstOrDefault();

                    await _activityUserServices.InsertActivityUserAsync(currentUser.Id, $"Approved a new connection with {connection.UserUsername}.");
                }
            }


            return RedirectToAction("Index", "Connection");
        }
        public async Task<IActionResult> UpdateStatusIdConnection(int id, int connectionStatusType)
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            if (connectionStatusType == (int)ConnectionStatusType.Canceled)
            {
                await _connectionServices.DeleteConnectionAsync(id, connectionStatusType);
            }
            else if (connectionStatusType == (int)ConnectionStatusType.Blocked || connectionStatusType == (int)ConnectionStatusType.Approved)
            {
                ConnectionModel connectionModel = new ConnectionModel();
                connectionModel.ConnectionUserId = id;

                var result = await _connectionServices.UpdateStatusConnectionAsync(id, connectionStatusType);


                if (connectionStatusType == (int)ConnectionStatusType.Blocked)
                {
                    var connection = await _connectionServices.GetConnectionAsync(new ConnectionModel() { ConnectionUserId = id });

                    await _connectionServices.AddConnectionBlockedAsync(connection.FirstOrDefault().UserConnectionId.Value, connection.FirstOrDefault().UserId.Value);
                }

                if (result >= 1 && connectionStatusType == (int)ConnectionStatusType.Approved)
                {
                    var resultConnections = await _connectionServices.GetConnectionAsync(new ConnectionModel() { ConnectionUserId = id });

                    var connection = resultConnections.Where(c => c.ConnectionUserId == id).FirstOrDefault();
                    await _activityUserServices.InsertActivityUserAsync(currentUser.Id, $"Approved a new connection with {connection.UserUsername}.");
                }
            }


            return RedirectToAction("Index", "Connection");
        }
    }
}
