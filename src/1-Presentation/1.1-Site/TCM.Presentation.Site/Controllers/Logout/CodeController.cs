using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using TCM.CrossCutting.Helpers;
using TCM.Presentation.Models;
using TCM.Services.Interfaces.Services;
using System.Security.Policy;
using System.Threading.Tasks;
using TCM.Services.Services;

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

        public async  Task< IActionResult> Mail(string token)
        {

            var parameters = ExtractValueFromKey.Extract(token);

            ViewBag.Token = token;

            await _sendMail.SendCodeAsync(parameters.User, parameters.Code);

            return View();
         }

        [HttpPost]
        public async Task<bool> Validate(string token, string code)
        {
            var result = false;
            var parameters = ExtractValueFromKey.Extract(token);

            var codeUser = await _codeServices.GetCodeByUserAsync(parameters.User);

            if (codeUser == null) result = false;

            if (code == codeUser.Code) result = true;

            return result;
        }

    }
}
