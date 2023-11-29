using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using TCM.CrossCutting.Helpers;

using TCM.Services.Interfaces.Services;
using System.Security.Policy;
using System.Threading.Tasks;
using TCM.Services.Services;
using TCM.Services.Model;
using System.Linq;
using Microsoft.AspNetCore.Authorization;
using Microsoft.Extensions.Logging;
using System;
using TCM.CrossCutting.Models;

namespace TCM.Presentation.Controllers.Logout
{
    [AllowAnonymous]
    public class CodeController : Controller
    {
        private readonly ICodeServices _codeServices;
        private readonly SendMail _sendMail;
        private readonly IUserServices _userServices;
        private readonly Utils _utils;
        private readonly ILogger<CodeController> _logger;
        public CodeController(ICodeServices codeServices, SendMail sendMail, IUserServices userServices, Utils utils, ILogger<CodeController> logger)
        {
            _codeServices = codeServices;
            _sendMail = sendMail;
            _userServices = userServices;
            _utils = utils;
            _logger = logger;
        }

        public IActionResult Index()
        {
            return View();
        }

        public async Task< IActionResult> Mail(string token)
        {
            Parameter parameters = null;

            ViewBag.Token = token;

            parameters = ExtractValueFromKey.Extract(token);

            await _sendMail.SendCodeAsync(parameters.User, parameters.Code);

            _logger.LogInformation($"Envio Email: {parameters.User}: Code: {parameters.Code}");

            return View();
         }

        [HttpPost]
        public async Task<JsonResult> Validate(string token, string code)
        {
            var resultModel = new ResultModel();

            var parameters = ExtractValueFromKey.Extract(token);

            var user = await _userServices.GetUserAsync(new UserModel() { Email = parameters.User });
            
            var result = await _codeServices.GetCodeByUserAsync(user.FirstOrDefault().UserName);

            if (result is null) return default;
            
            if (code.ToUpper() == result.Code)
            {
                
                var userMode = await _userServices.GetUserAsync(new UserModel() { Id = result.UserId } );

                var tokenJWT = _utils.GenerateToken(userMode.FirstOrDefault());

                HttpContext.Session.SetString("Token", tokenJWT);

                resultModel.StatusCode = System.Net.HttpStatusCode.OK;
                resultModel.Data = result;
                resultModel.IsOK = true;
                resultModel.Token = tokenJWT;

                if (parameters.FirstAccess)
                {
                    if (userMode.Count() > 0) await _sendMail.SendWelcomeAsync(userMode.FirstOrDefault().Email, userMode.FirstOrDefault().FullName);
                }

                await _userServices.UpdateLastAccessDateAsync(userMode.FirstOrDefault().Id.Value);

                HttpContext.Session.SetString("ProfileId", ((int)userMode.FirstOrDefault().ProfileId).ToString());

                if (userMode.FirstOrDefault().ProfileId == Services.Model.Enum.UserType.User)
                {
                    resultModel.Redirect = "/Home";
                }
                else
                {
                    resultModel.Redirect = "/Home/Adm";
                }
            }
            else
            {
                resultModel.StatusCode = System.Net.HttpStatusCode.InternalServerError;
                resultModel.IsOK = false;
            }

            return new JsonResult(resultModel);
        }

    }
}
