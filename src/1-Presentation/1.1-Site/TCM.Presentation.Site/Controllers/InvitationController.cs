using Microsoft.AspNetCore.Mvc;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using TCM.CrossCutting.Helpers;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers
{
    public class InvitationController : Controller
    {

        private readonly IConnectionServices _connectionService;

        public InvitationController(IConnectionServices connectionService)
        {
            _connectionService = connectionService;
        }

        public IActionResult Index(List<ConnectionModel> models)
        {
            return View(models);
        }

        [HttpGet]
        public async Task<JsonResult> GetUser([FromQuery]string email)
        {
            var result = await _connectionService.GetUserConnectionAsync(email);

            if (!result.Any())
            {
                return new JsonResult(new ResultModel()
                {
                    StatusCode = HttpStatusCode.InternalServerError,
                    IsOK = false,
                    Errors = "Não foi encontrado nenhum usuário"
                });
            }
            else
            {
                return new JsonResult(new ResultModel()
                {
                    StatusCode = result.Any() ? HttpStatusCode.OK : HttpStatusCode.InternalServerError,
                    IsOK = true,
                    Data = result,
                    Redirect = "/Invitation/InvitationUsers"

                });
            }
        }
        [HttpPost]
        public async Task<IActionResult> InvitationUsers([FromBody] List<ConnectionModel> models)
        {
            return PartialView("InvitationUsers", models);
        }
    }
}
