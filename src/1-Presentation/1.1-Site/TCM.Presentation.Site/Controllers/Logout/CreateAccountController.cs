using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Newtonsoft.Json.Linq;
using System.Net;
using System.Threading.Tasks;
using System.Web.Helpers;
using TCM.CrossCutting.Helpers;
using TCM.Presentation.Controllers.Logout;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using TCM.Services.Services;
using static Microsoft.ApplicationInsights.MetricDimensionNames.TelemetryContext;

namespace TCM.Presentation.Site.Controllers.Logout
{
    public class CreateAccountController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly ICodeServices _codeServices;
        private readonly SendMail _sendMail;

        public CreateAccountController(IUserServices userServices, SendMail sendMail, ICodeServices codeServices)
        {
            _userServices = userServices;
            _sendMail = sendMail;
            _codeServices = codeServices;
        }

        public IActionResult Index()
        {
            return View();
        }

        [HttpPost]
        public async Task<JsonResult> AddUser([FromBody] UserModel userModel)
        {
            if (userModel.Password != userModel.ConfirmPassword)
                return new JsonResult(new ResultModel()
                {
                    StatusCode = HttpStatusCode.InternalServerError,
                    Errors = "Senha não é igual",
                    Type = "Password",
                    IsOK = false
                }) ;

            var result = await _userServices.AddUserAsync(userModel);

            var resultModel = new ResultModel();
            
            if (result > 0)
            {
                var code = Code.GeneratedCode(6);

                var resultLogin = await _userServices.GetLoginAsync(userModel.UserName, userModel.Password);

                var resultCode = await _codeServices.SaveCodeAsync(resultLogin?.Id, code);

                if (resultCode > 0)
                {
                    resultModel.StatusCode = System.Net.HttpStatusCode.OK;
                    resultModel.Data = resultLogin;
                    resultModel.IsOK = true;
                    resultModel.Redirect = GeneratedToken(resultLogin.Email, code, true);
                }
            }

            return new JsonResult(resultModel);
        }

        private string GeneratedToken(string user, string code, bool firstAccess)
        {
            var url = $"/Code/Mail?";

            var param = $"user={user}&code={code}&firstaccess={firstAccess}";

            return $"{url}token={Encrypt.EncodeBase64(param)}";
        }
    }
}
