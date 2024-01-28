using Microsoft.AspNetCore.Mvc;
using System.Net;
using System.Threading.Tasks;
using TCM.CrossCutting.Helpers;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers
{
    public class CreateAccountController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly ICodeServices _codeServices;
        private readonly IConnectionServices _connectionServices;
        private readonly SendMail _sendMail;

        public CreateAccountController(IUserServices userServices, SendMail sendMail, ICodeServices codeServices, IConnectionServices connectionServices)
        {
            _userServices = userServices;
            _sendMail = sendMail;
            _codeServices = codeServices;
            _connectionServices = connectionServices;
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
                    Errors = "PIN not equal",
                    Type = "Password",
                    IsOK = false
                });

            var result = await _userServices.AddUserAsync(userModel);

            if (result == -1)
            {
                return new JsonResult(new ResultModel()
                {
                    StatusCode = HttpStatusCode.InternalServerError,
                    Errors = "Email already exists in the database",
                    Type = "EmailExists",
                    IsOK = false
                });
            }

            if (result == -2)
            {
                return new JsonResult(new ResultModel()
                {
                    StatusCode = HttpStatusCode.InternalServerError,
                    Errors = "User already exists in the database",
                    Type = "UserExists",
                    IsOK = false
                });
            }

            var resultModel = new ResultModel();

            if (result > 0)
            {
                var code = Code.GeneratedCode(6);

                var resultLogin = await _userServices.GetLoginAsync(userModel.UserName, userModel.Password);

                await _connectionServices.AddConnectionAsync(1, resultLogin.Id.Value, Services.Model.Enum.ConnectionStatusType.Approved);

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
