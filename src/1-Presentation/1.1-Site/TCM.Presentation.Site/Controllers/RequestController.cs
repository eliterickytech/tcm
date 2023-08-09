using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System;
using TCM.Presentation.Site.Models;
using TCM.Services.Model;
using Microsoft.Extensions.Logging;
using TCM.Services.Interfaces.Services;
using System.Security.Claims;
using TCM.Services.Model.Enum;

namespace TCM.Presentation.Site.Controllers
{
    public class RequestController : Controller
    {
        private readonly IConnectionServices _connectionService;
        private readonly ILogger<RequestController> _logger;
        private readonly ISearchServices _searchServices;

        public RequestController(IConnectionServices connectionService, ILogger<RequestController> logger, ISearchServices searchServices)
        {
            _connectionService = connectionService;
            _logger = logger;
            _searchServices = searchServices;
        }
        public async Task<IActionResult> Index()
        {
            if (HttpContext.Session.GetString("SearchRequestUser") != null)
            {
                TempData["SearchRequestUser"] = Newtonsoft.Json.JsonConvert.DeserializeObject<List<ResultSearchModel>>(HttpContext.Session.GetString("SearchRequestUser"));
                HttpContext.Session.Remove("SearchRequestUser");
            }
            else
            {
                var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2";

                var resultSearchModels = new List<ResultSearchModel>(); 
                var resultsUser = await _connectionService.GetConnectionAsync(Convert.ToInt32(id));

                var resultConnections = await _connectionService.GetConnectionAsync(new ConnectionModel() { ConnectionUserId = Convert.ToInt32(id) });

                resultsUser.ToList().Where(x => 
                x.ConnectionUserId == Convert.ToInt32(id) &&
                (x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Pending || 
                x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Requested)).ToList().ForEach(x =>
                {
                    resultSearchModels.Add(new ResultSearchModel()
                    {
                        ConnectionId = x.ConnectionUserId ?? 0,
                        ConnectionStatus = x.ConnectionUserConnectionStatusId,
                        ConnectionUserId = x.UserConnectionId,
                        Username = x.UserUsername,
                        CountCollection = 0,
                    });
                });

                resultConnections.ToList().Where(x =>
                (x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Pending ||
                x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Requested)).ToList().ForEach(x =>
                {
                    resultSearchModels.Add(new ResultSearchModel()
                    {
                        ConnectionId = x.ConnectionUserId ?? 0,
                        ConnectionStatus = x.ConnectionUserConnectionStatusId,
                        ConnectionUserId = x.UserId,
                        Username = x.UserUsername,
                        CountCollection = 0,
                    });
                });

                HttpContext.Session.SetString("SearchRequestUser", Newtonsoft.Json.JsonConvert.SerializeObject(resultSearchModels));

                TempData["SearchRequestUser"] = Newtonsoft.Json.JsonConvert.DeserializeObject<List<ResultSearchModel>>(HttpContext.Session.GetString("SearchRequestUser"));
            }

            return View();
        }

        [HttpPost]
        public async Task<List<ResultSearchModel>> Results(SearchModel search)
        {
            List<ResultSearchModel> results = new List<ResultSearchModel>();

            if (!string.IsNullOrEmpty(search.SearchText))
            {
                var connections = await _connectionService.GetUserConnectionAsync(search.SearchText);

                foreach (var connection in connections)
                {
                    results.Add(new ResultSearchModel()
                    {
                        ConnectionId = connection.ConnectionUserId ?? 0,
                        ConnectionStatus = connection.ConnectionUserConnectionStatusId,
                        ConnectionUserId = connection.UserConnectionId,
                        Username = connection.UserConnectionUsername,
                        CountCollection = 0,
                    });
                }
            }

            HttpContext.Session.SetString("SearchRequestUser", Newtonsoft.Json.JsonConvert.SerializeObject(results));
            return results;

        }

        [HttpGet]
        public async Task Action(int connectionStatusId, int connectionId)
        {
            if (connectionStatusId == (int)ConnectionStatusType.Canceled)
            {
                await _connectionService.DeleteConnectionAsync(connectionId, connectionStatusId);
            }
            else if (connectionStatusId == (int)ConnectionStatusType.Blocked || connectionStatusId == (int)ConnectionStatusType.Approved)
            {
                await _connectionService.UpdateStatusConnectionAsync(connectionId, connectionStatusId);
            }
            TempData["SearchRequestUser"] = null;
            HttpContext.Session.Remove("SearchRequestUser");
        }
    }
}
