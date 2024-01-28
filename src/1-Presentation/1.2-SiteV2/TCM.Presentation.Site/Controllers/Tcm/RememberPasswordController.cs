using Microsoft.AspNetCore.Mvc;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using TCM.CrossCutting.Helpers;
using TCM.CrossCutting.Models;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class RememberPasswordController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly SendMail _sendMail;
        private readonly Utils _utils;

        public RememberPasswordController(IUserServices userServices, Utils utils, SendMail sendMail)
        {
            _userServices = userServices;
            _utils = utils;
            _sendMail = sendMail;
        }

        public IActionResult Index()
        {
            return View();
        }

        public IActionResult Change(string token)
        {
            Parameter parameters = null;

            parameters = ExtractValueFromKey.Extract(token);

            ViewBag.Username = parameters.User.Replace("name=", string.Empty);

            return View();
        }

        [HttpGet]
        public async Task<JsonResult> Remember(string username)
        {
            var result = await _userServices.GetUserAsync(new Services.Model.UserModel() { UserName = username });

            if (result.Any())
            {
                await _sendMail.SendRememberPasswordAsync(result.FirstOrDefault().Email, GeneratedToken(username), username);

                return new JsonResult(new
                {
                    StatusCode = HttpStatusCode.OK,
                    IsOK = true,
                    Data = "E-mail with instructions sent to your e-mail address"
                });
            }
            else
            {
                return new JsonResult(new
                {
                    StatusCode = HttpStatusCode.BadRequest,
                    IsOK = false,
                    errors = "Username does not exist in our database"
                });
            }
        }

        private string GeneratedToken(string username)
        {
            var url = $"RememberPassword/Change?";

            var param = $"username={username}";

            return $"{url}token={Encrypt.EncodeBase64(param)}";
        }

        [HttpPost]
        public async Task<JsonResult> ChangePassawordUser([FromBody] UserModel userModel)
        {
            if (userModel.Password != userModel.ConfirmPassword)
                return new JsonResult(new ResultModel()
                {
                    StatusCode = HttpStatusCode.BadRequest,
                    Errors = "PIN not Equals",
                    Type = "Password",
                    IsOK = false
                });

            var user = await _userServices.GetUserAsync(new Services.Model.UserModel() { UserName = userModel.UserName });

            if (user.Any())
            {
                var result = await _userServices.ChangeUserPasswordAsync((int)user.FirstOrDefault().Id, userModel.Password);

                return new JsonResult(new ResultModel()
                {
                    StatusCode = result > 0 ? HttpStatusCode.OK : HttpStatusCode.BadRequest,
                    IsOK = true,
                    Data = "PIN has been changed successfully",
                    Type = "ChangedPIN",
                    Redirect = "/Login"
                });
            }
            else
            {
                return new JsonResult(new ResultModel()
                {
                    StatusCode = HttpStatusCode.BadRequest,
                    Errors = "Username does not exist in our database",
                    Type = "Password",
                    IsOK = false
                });
            }
        }
    }
}
