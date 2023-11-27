using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using TCM.Services.Model.Enum;

namespace TCM.Presentation.Site.Controllers
{

    public class InvitationController : Controller
    {

        private readonly IConnectionServices _connectionService;
        private readonly ILogger<InvitationController> _logger;
        private readonly ISearchServices _searchServices;

        public InvitationController(IConnectionServices connectionService, ILogger<InvitationController> logger, ISearchServices searchServices)
        {
            _connectionService = connectionService;
            _logger = logger;
            _searchServices = searchServices;
        }
        //[Authorize]
        public async Task<IActionResult> Index()
        {
            if (!User.Identity.IsAuthenticated) return RedirectToAction("Index", "Login");

            if (HttpContext.Session.GetString("SearchInvitationUser") != null)
            {
                TempData["SearchInvitationUser"] = Newtonsoft.Json.JsonConvert.DeserializeObject<List<ResultSearchModel>>(HttpContext.Session.GetString("SearchInvitationUser"));
                HttpContext.Session.Remove("SearchInvitationUser");
            }
            else
            {
                var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;

                var resultSearchModels = new List<ResultSearchModel>();
                var resultUsers = await _connectionService.GetConnectionAsync(Convert.ToInt32(id));

                //var resultConnections = await _connectionService.GetConnectionAsync(new ConnectionModel() { ConnectionUserId = Convert.ToInt32(id) });

                resultUsers.ToList().Where(x =>
                (x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Pending ||
                x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Requested)).ToList().ForEach(x =>
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

                //resultConnections.ToList().Where(x =>
                //(x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Pending ||
                //x.ConnectionUserConnectionStatusId == (int)ConnectionStatusType.Requested)).ToList().ForEach(x =>
                //{
                //    resultSearchModels.Add(new ResultSearchModel()
                //    {
                //        ConnectionId = x.ConnectionUserId ?? 0,
                //        ConnectionStatus = x.ConnectionUserConnectionStatusId,
                //        ConnectionUserId = x.UserId,
                //        Username = x.UserUsername,
                //        CountCollection = 0,
                //    });
                //});

                HttpContext.Session.SetString("SearchInvitationUser", Newtonsoft.Json.JsonConvert.SerializeObject(resultSearchModels));

                TempData["SearchInvitationUser"] = Newtonsoft.Json.JsonConvert.DeserializeObject<List<ResultSearchModel>>(HttpContext.Session.GetString("SearchInvitationUser"));
            }
            return View();
        }

        [HttpPost]
        public IActionResult Index([FromBody] List<ConnectionModel> models)
        {
            if (!User.Identity.IsAuthenticated) return RedirectToAction("Index", "Login");

            TempData["Connection"] = models;
            return View();
        }

        [HttpPost]
        public async Task<JsonResult> AddInvitation(ConnectionUserModel connetionuserid)
        {
            if (connetionuserid.ConnectionUserId > 0) 
            {
                var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;
                var result = await _connectionService.AddConnectionAsync(Convert.ToInt32(id), connetionuserid.ConnectionUserId);

                return new JsonResult(new ResultModel()
                {
                    StatusCode = result > 1 ? HttpStatusCode.OK : HttpStatusCode.InternalServerError,
                    IsOK = true,
                    Data = result,
                    Redirect = "/Connection"

                });
            }
            else
            {
                return new JsonResult(new ResultModel() { StatusCode = HttpStatusCode.InternalServerError });
            }
        }

        [HttpPost]
        public async Task<List<ResultSearchModel>> Results(SearchModel search)
        {
            List<ResultSearchModel> results = new List<ResultSearchModel>();

            if (!string.IsNullOrEmpty(search.SearchText))
            {
                var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;

                results = await _searchServices.SearchUserAsync(search.SearchText, Convert.ToInt32(id));
            }

            HttpContext.Session.SetString("SearchInvitationUser", Newtonsoft.Json.JsonConvert.SerializeObject(results));
            return results;
        }

    }
}
