using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using TCM.CrossCutting.Helpers;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using System;
using System.Threading.Tasks;
using TCM.Services.Model.Enum;

namespace TCM.Presentation.Controllers.Logout
{
    public class LoginController : Controller
    {

        private readonly IUserServices _userServices;
        private readonly ICodeServices _codeServices;

        public LoginController(IUserServices userServices, ICodeServices codeServices)
        {
            _userServices = userServices;
            _codeServices = codeServices;
        }

        public IActionResult Index()
        {
            return View();
        }

        public async Task<JsonResult> GetUser(string user, string password)
        {
            var result = await _userServices.GetLoginAsync(user, password);

            var resultModel = new ResultModel();

            if (result is null)
            {
                resultModel.StatusCode = System.Net.HttpStatusCode.OK;
                resultModel.Errors = "Usuário/Senha inválido!";
                resultModel.Type = "InvalidPassword";
                resultModel.IsOK = false;
            }
            else
            {
                var code = Code.GeneratedCode(6);

                var resultCode = await _codeServices.SaveCodeAsync(result?.Id, code);

                if (resultCode > 0)
                {
                    resultModel.StatusCode = System.Net.HttpStatusCode.OK;
                    resultModel.Data = result;
                    resultModel.IsOK = true;
                    resultModel.Redirect = GeneratedToken(result.Email, code);
                }
            }

            return new JsonResult(resultModel);
        }

        private string GeneratedToken(string user, string code)
        {
            var url = $"/Code/Mail?";

            var param = $"user={user}&code={code}";

            return $"{url}token={Encrypt.EncodeBase64(param)}";
        }
    }
}
