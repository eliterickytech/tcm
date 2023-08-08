using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.CrossCutting.Helpers;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using TCM.Services.Services;

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

        public IActionResult Index()
        {
            if (HttpContext.Session.GetString("SearchInvitationUser") != null)
            {
                TempData["SearchInvitationUser"] = Newtonsoft.Json.JsonConvert.DeserializeObject<List<ResultSearchModel>>(HttpContext.Session.GetString("SearchInvitationUser"));
            }

            return View();
        }

        [HttpPost]
        public IActionResult Index([FromBody] List<ConnectionModel> models)
        {
            TempData["Connection"] = models;
            return View();
        }

        [HttpPost]
        public async Task<JsonResult> AddInvitation(ConnectionUserModel connetionuserid)
        {
            if (connetionuserid.ConnectionUserId > 0) 
            {
                var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "1";
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
                var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "1";

                results = await _searchServices.SearchUserAsync(search.SearchText, Convert.ToInt32(id));
            }

            HttpContext.Session.SetString("SearchInvitationUser", Newtonsoft.Json.JsonConvert.SerializeObject(results));
            return results;
        }
    }
}
