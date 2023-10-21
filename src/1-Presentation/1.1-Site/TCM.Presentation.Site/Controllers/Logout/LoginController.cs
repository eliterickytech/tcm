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

        public LoginController(IUserServices userServices)
        {
            _userServices = userServices;
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


    }
}
