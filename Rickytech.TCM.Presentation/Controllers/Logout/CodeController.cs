using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Rickytech.CrossCutting.Helpers;
using Rickytech.TCM.Presentation.Models;
using Rickytech.TCM.Services.Interfaces.Services;
using System.Security.Policy;
using System.Threading.Tasks;

namespace Rickytech.TCM.Presentation.Controllers.Logout
{
    public class CodeController : Controller
    {
        private readonly ICodeServices _codeServices;

        public CodeController(ICodeServices codeServices)
        {
            _codeServices = codeServices;
        }

        public IActionResult Index()
        {
            return View();
        }

        public IActionResult Mobile(string token)
        {
            return View();
        }

        [HttpPost]
        public Task<CodeViewModel> VerifyCodeMobile(CodeViewModel codeViewModel)
        {
            if (codeViewModel is null) return default;

            return Task.FromResult(new CodeViewModel() { Code = codeViewModel.Code, Token = codeViewModel.Token, Redirect = "/Home"});            
        }

    }
}
