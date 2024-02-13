using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System.Threading.Tasks;
using System;
using TCM.Services.Interfaces.Services;
using TCM.CrossCutting.Helpers;
using TCM.Services.Model;
using System.Linq;
using TCM.Presentation.Site.Models;

namespace TCM.Presentation.Site.Controllers
{
    public class LoginController : Controller
    {
        private readonly TCM.CrossCutting.Helpers.Utils _utils;
        private readonly IUserServices _userServices;
        private readonly ICodeServices _codeServices;

        public LoginController(IUserServices userServices, TCM.CrossCutting.Helpers.Utils utils, ICodeServices codeServices)
        {
            _userServices = userServices;
            _utils = utils;
            _codeServices = codeServices;
        }

        public IActionResult Index()
        {
            return View();
        }
        public IActionResult Logoff()
        {
            HttpContext.Session.Clear();

            return RedirectToAction("Index", "Login");
        }
        [HttpPost]
        public async Task<JsonResult> LoginUser([FromBody] LoginViewModel model)
        {
            var result = await _userServices.GetLoginAsync(model.User, model.Password);

            var resultModel = new ResultModel();

            if (result is null)
            {
                resultModel.StatusCode = System.Net.HttpStatusCode.OK;
                resultModel.Errors = "User/Pin Invalid!";
                resultModel.Type = "InvalidPassword";
                resultModel.IsOK = false;
            }
            else
            {
                var userMode = await _userServices.GetUserAsync(new UserModel() { Id = result.Id });

                if (result.ProfileId == TCM.Services.Model.Enum.UserType.User)
                {

                    if (DateTime.Now > result.LastAccessDate.AddDays(15))
                    {

                        if (result != null)
                        {

                            var code = Code.GeneratedCode(6);

                            var resultCode = await _codeServices.SaveCodeAsync(result?.Id, code);

                            if (resultCode > 0)
                            {
                                resultModel.StatusCode = System.Net.HttpStatusCode.OK;
                                resultModel.Data = result;
                                resultModel.IsOK = true;
                                resultModel.Redirect = GeneratedToken(result.Email, code, false);
                            }
                        }

                        return new JsonResult(resultModel);
                    }
                }

                var tokenJWT = _utils.GenerateToken(userMode.FirstOrDefault());

                HttpContext.Session.SetString("Token", tokenJWT);

                resultModel.StatusCode = System.Net.HttpStatusCode.OK;
                resultModel.Data = result;
                resultModel.IsOK = true;
                resultModel.Token = tokenJWT;

                await _userServices.UpdateLastAccessDateAsync(result.Id.Value);
             
                HttpContext.Session.SetString("ProfileId", ((int)result.ProfileId).ToString());
                HttpContext.Session.SetString("UserName", result.UserName);
                HttpContext.Session.SetString("Email", result.Email);
                HttpContext.Session.SetString("Id", result.Id.Value.ToString());                               

                if (result.ProfileId ==  TCM.Services.Model.Enum.UserType.User)
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
