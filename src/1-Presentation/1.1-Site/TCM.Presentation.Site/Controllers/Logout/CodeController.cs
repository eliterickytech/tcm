using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using TCM.CrossCutting.Helpers;

using TCM.Services.Interfaces.Services;
using System.Security.Policy;
using System.Threading.Tasks;
using TCM.Services.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Controllers.Logout
{
    public class CodeController : Controller
    {
        private readonly ICodeServices _codeServices;
        private readonly SendMail _sendMail;
        public CodeController(ICodeServices codeServices, SendMail sendMail)
        {
            _codeServices = codeServices;
            _sendMail = sendMail;
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

            var result = await _codeServices.GetCodeByUserAsync(parameters.User);

            if (result is null) return default;

            if (code == result.Code)
            {
                resultModel.StatusCode = System.Net.HttpStatusCode.OK;
                resultModel.Data = result;
                resultModel.IsOK = true;
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
