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

namespace TCM.Presentation.Site.Controllers.Logout
{
    public class CreateAccountController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly SendMail _sendMail;
        public CreateAccountController(IUserServices userServices, SendMail sendMail)
        {
            _userServices = userServices;
            _sendMail = sendMail;
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

            if (result > 0) await _sendMail.SendWelcomeAsync(userModel.Email, userModel.FullName);

            return new JsonResult(new ResultModel()
            {
                StatusCode = result > 0 ? HttpStatusCode.OK : HttpStatusCode.InternalServerError,
                IsOK = true,
                Data = result,
                Redirect = "/Login"
            });
        }
    }
}
