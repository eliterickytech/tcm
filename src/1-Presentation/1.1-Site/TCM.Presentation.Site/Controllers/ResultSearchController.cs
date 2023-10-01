using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Reflection;
using System.Security.Claims;
using System.Threading.Tasks;
using TCM.Presentation.Site.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using static Dapper.SqlMapper;

namespace TCM.Presentation.Site.Controllers
{
    public class ResultSearchController : Controller
    {
        private readonly ILogger<ResultSearchController> _logger;
        private readonly ISearchServices _searchServices ;

        public ResultSearchController(ILogger<ResultSearchController> logger, ISearchServices searchServices)
        {
            _logger = logger;
            _searchServices = searchServices;
        }
        //[Authorize]
        public async Task<IActionResult> Index()
        { 
            if (HttpContext.Session.GetString("SearchUser") != null)
            {
                TempData["SearchUser"] = Newtonsoft.Json.JsonConvert.DeserializeObject<List< ResultSearchModel >>( HttpContext.Session.GetString("SearchUser"));
            }

            return View();
        }
        [HttpPost]
        public async Task<List<ResultSearchModel>> Results(SearchModel search)
        {
            List<ResultSearchModel> results = new List<ResultSearchModel>();

            if (!string.IsNullOrEmpty(search.SearchText))
            {
                var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value ?? "2";

                results = await _searchServices.SearchUserAsync(search.SearchText, Convert.ToInt32(id));
            }

            HttpContext.Session.SetString("SearchUser", Newtonsoft.Json.JsonConvert.SerializeObject(results));
            return results;
        }
    }
}
