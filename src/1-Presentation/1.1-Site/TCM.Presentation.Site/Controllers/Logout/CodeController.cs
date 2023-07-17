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

namespace TCM.Presentation.Controllers.Logout
{
    [AllowAnonymous]
    public class CodeController : Controller
    {
        private readonly ICodeServices _codeServices;
        private readonly SendMail _sendMail;
        private readonly IUserServices _userServices;
        private readonly Utils _utils;
        
        public CodeController(ICodeServices codeServices, SendMail sendMail, IUserServices userServices, Utils utils)
        {
            _codeServices = codeServices;
            _sendMail = sendMail;
            _userServices = userServices;
            _utils = utils;
        }

        public IActionResult Index()
        {
            return View();
        }

        public async Task< IActionResult> Mail(string token)
        {

            var parameters = ExtractValueFromKey.Extract(token);

            ViewBag.Token = token;

            await _sendMail.SendCodeAsync(parameters.User, parameters.Code);

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
            
            if (code == result.Code)
            {
                
                var userMode = await _userServices.GetUserAsync(new UserModel() { Id = result.UserId } );
                var tokenJWT = _utils.GenerateToken(userMode.FirstOrDefault());

                HttpContext.Session.SetString("Token", tokenJWT);

                resultModel.StatusCode = System.Net.HttpStatusCode.OK;
                resultModel.Data = result;
                resultModel.IsOK = true;
                resultModel.Token = tokenJWT;
                resultModel.Redirect = "/Home";
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
