using Microsoft.AspNetCore.Mvc;
using System;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using TCM.Services.Model.Enum;
using TCM.Services.Services;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class ConnectionRequestController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly IConnectionServices _connectionServices;
        private readonly IActivityUserServices _activityUserServices;

        public ConnectionRequestController(IUserServices userServices, IConnectionServices connectionServices, IActivityUserServices activityUserServices)
        {
            _userServices = userServices;
            _connectionServices = connectionServices;
            _activityUserServices = activityUserServices;
        }

        public async Task<IActionResult> Index()
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var connections = await _connectionServices.ListConnectionsByUserIdAsync(currentUser.Id);

            connections = connections.Where(x => x.ConnectionStatusId == (int)ConnectionStatusType.Requested).ToList();

            return View(connections);
        }

        [HttpGet]
        public async Task Action(int connectionStatusId, int connectionId, int userId)
        {
            if (connectionStatusId == (int)ConnectionStatusType.Canceled)
            {
                await _connectionServices.DeleteConnectionAsync(connectionId, connectionStatusId);
            }
            else if (connectionStatusId == (int)ConnectionStatusType.Blocked || connectionStatusId == (int)ConnectionStatusType.Approved)
            {
                ConnectionModel connectionModel = new ConnectionModel();
                connectionModel.ConnectionUserId = connectionId;

                var result = await _connectionServices.UpdateStatusConnectionAsync(connectionId, connectionStatusId);

                if (result >= 1 && connectionStatusId == (int)ConnectionStatusType.Approved)
                {
                    var resultConnections = await _connectionServices.GetConnectionAsync(new ConnectionModel() { ConnectionUserId = userId });

                    var connection = resultConnections.Where(c => c.ConnectionUserId == connectionId).FirstOrDefault();
                    await _activityUserServices.InsertActivityUserAsync(userId, $"Approved a new connection with {connection.UserUsername}.");
                }
            }
        }
    }
}
