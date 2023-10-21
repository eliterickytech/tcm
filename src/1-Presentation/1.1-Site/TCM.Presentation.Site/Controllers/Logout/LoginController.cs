using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using TCM.CrossCutting.Helpers;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using System;
using System.Threading.Tasks;
using TCM.Services.Model.Enum;
using Microsoft.AspNetCore.Http;
using SendGrid.SmtpApi;
using TCM.Services.Services;
using System.Linq;

namespace TCM.Presentation.Controllers.Logout
{
    public class LoginController : Controller
    {
        private readonly TCM.CrossCutting.Helpers.Utils _utils;
        private readonly IUserServices _userServices;
        private readonly ICodeServices _codeServices;

        public LoginController(IUserServices userServices, CrossCutting.Helpers.Utils utils, ICodeServices codeServices)
        {
            _userServices = userServices;
            _utils = utils;
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
                var userMode = await _userServices.GetUserAsync(new UserModel() { Id = result.Id });

                if (result.LastAccessDate.AddDays(15) >= DateTime.Now)
                {

                    if (result != null)
                    {

                        var code = Code.GeneratedCode(6);

                        var resultLogin = await _userServices.GetLoginAsync(user, password);

                        var resultCode = await _codeServices.SaveCodeAsync(resultLogin?.Id, code);

                        if (resultCode > 0)
                        {
                            resultModel.StatusCode = System.Net.HttpStatusCode.OK;
                            resultModel.Data = resultLogin;
                            resultModel.IsOK = true;
                            resultModel.Redirect = GeneratedToken(resultLogin.Email, code, false);
                        }
                    }

                    return new JsonResult(resultModel);
                }

                var tokenJWT = _utils.GenerateToken(userMode.FirstOrDefault());

                HttpContext.Session.SetString("Token", tokenJWT);

                resultModel.StatusCode = System.Net.HttpStatusCode.OK;
                resultModel.Data = result;
                resultModel.IsOK = true;
                resultModel.Token = tokenJWT;


                if (result.ProfileId == Services.Model.Enum.UserType.User)
                {
                    resultModel.Redirect = "/Home";
                }
                else
                {
                    resultModel.Redirect = "/Home/Adm";
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
