using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;
using System.Linq;
using System;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Model;
using Microsoft.Extensions.Logging;
using TCM.Services.Interfaces.Services;
using System.Security.Claims;
using TCM.Services.Model.Enum;

namespace TCM.Presentation.Site.Controllers
{
    public class ConnectionController : Controller
    {

        private readonly IConnectionServices _connectionService;
        private readonly ILogger<ConnectionController> _logger;
        private readonly ISearchServices _searchServices;

        public ConnectionController(IConnectionServices connectionService, ILogger<ConnectionController> logger, ISearchServices searchServices)
        {
            _connectionService = connectionService;
            _logger = logger;
            _searchServices = searchServices;
        }

        public async Task<IActionResult> Index()
        {
            if (HttpContext.Session.GetString("SearchConnectionUser") != null)
            {
                TempData["SearchConnectionUser"] = Newtonsoft.Json.JsonConvert.DeserializeObject<List<ResultSearchModel>>(HttpContext.Session.GetString("SearchConnectionUser"));
            }
            else
            {
                var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "1";

                var resultSearchModels = new List<ResultSearchModel>();
                var results = await _connectionService.GetConnectionAsync(Convert.ToInt32(id));

                results.ToList().Where(x => x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Canceled || x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Approved || x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Blocked).ToList().ForEach(x =>
                {
                    resultSearchModels.Add(new ResultSearchModel()
                    {
                        ConnectionId = x.ConnectionUserId ?? 0,
                        ConnectionStatus = x.ConnectionUserConnectionStatusId,
                        ConnectionUserId = x.UserConnectionId,
                        Username = x.UserConnectionUsername,
                        CountCollection = 0,
                    });
                });

                HttpContext.Session.SetString("SearchConnectionUser", Newtonsoft.Json.JsonConvert.SerializeObject(resultSearchModels));

                TempData["SearchConnectionUser"] = Newtonsoft.Json.JsonConvert.DeserializeObject<List<ResultSearchModel>>(HttpContext.Session.GetString("SearchConnectionUser"));

            }
            return View();
        }

        //[HttpPost]
        //public async Task<List<ResultSearchModel>> RequestResults(SearchModel search)
        //{
        //    List<ResultSearchModel> results = new List<ResultSearchModel>();

        //    if (!string.IsNullOrEmpty(search.SearchText))
        //    {
        //        var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "1";

        //        results = await _searchServices.SearchUserAsync(search.SearchText, Convert.ToInt32(id));
        //    }

        //    HttpContext.Session.SetString("SearchConnectionUser", Newtonsoft.Json.JsonConvert.SerializeObject(results));
        //    return results;
        //}

        [HttpPost]
        public async Task<List<ResultSearchModel>> ConnectionResults(SearchModel search)
        {
            List<ResultSearchModel> results = new List<ResultSearchModel>();

            if (!string.IsNullOrEmpty(search.SearchText))
            {
                var connections = await _connectionService.GetUserConnectionAsync(search.SearchText);

                foreach (var connection in connections)
                {
                    results.Add(new ResultSearchModel()
                    {
                        ConnectionStatus = connection.ConnectionUserConnectionStatusId,
                        ConnectionUserId = connection.UserConnectionId,
                        Username = connection.UserConnectionUsername,
                        CountCollection = 0,
                    });
                }
            }

            HttpContext.Session.SetString("SearchConnectionUser", Newtonsoft.Json.JsonConvert.SerializeObject(results));
            return results;
        }

        [HttpGet]
        public async Task Action(int connectionStatusId, int connectionId)
        {
            if (connectionStatusId == (int)ConnectionStatusType.Canceled)
            {
                var id = await _connectionService.DeleteConnectionAsync(connectionId, connectionStatusId);
            }
            else if (connectionStatusId == (int)ConnectionStatusType.Blocked)
            {
                await _connectionService.UpdateStatusConnectionAsync(connectionId, connectionStatusId);
            }
            TempData["SearchConnectionUser"] = null;
            HttpContext.Session.Remove("SearchConnectionUser");
        }

    }
}
