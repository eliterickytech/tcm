using Microsoft.AspNetCore.Mvc;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using TCM.CrossCutting.Helpers;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using TCM.Services.Services;

namespace TCM.Presentation.Site.Controllers
{
    public class UserController : Controller
    {
        private readonly IConnectionServices _connectionServices;     
        private readonly IUserServices _userServices;
        public UserController(IConnectionServices connectionServices, IUserServices userServices)
        {
            _connectionServices = connectionServices;
            _userServices = userServices;
        }

        public IActionResult Index()
        {
            return View();
        }
        public IActionResult Change() 
        {
            return View();
        }

        [HttpGet]
        public async Task<JsonResult> GetUserConnection([FromQuery] string userName)
        {
            var result = await  _connectionServices.GetUserConnectionAsync(userName);

            if (!result.Any())
            {
                return new JsonResult(new ResultModel()
                {
                    StatusCode = HttpStatusCode.InternalServerError,
                    IsOK = false,
                    Errors = "Não foi encontrado nenhum usuário"
                });
            }
            else
            {
                return new JsonResult(new ResultModel()
                {
                    StatusCode = result.Any() ? HttpStatusCode.OK : HttpStatusCode.InternalServerError,
                    IsOK = true,
                    Data = result,
                    Redirect = "/Invitation"

                });
            }
        }

        [HttpGet]
        public async Task<JsonResult> GetUser([FromQuery] string userName)
        {
            var result = await _userServices.GetUserAsync(new UserModel() { UserName = userName });

            if (!result.Any())
            {
                return new JsonResult(new ResultModel()
                {
                    StatusCode = HttpStatusCode.InternalServerError,
                    IsOK = false,
                    Errors = "Não foi encontrado nenhum usuário"
                });
            }
            else
            {
                return new JsonResult(new ResultModel()
                {
                    StatusCode = result.Any() ? HttpStatusCode.OK : HttpStatusCode.InternalServerError,
                    IsOK = true,
                    Data = result,
                    Redirect = "/Invitation"

                });
            }
        }

        [HttpPost]
        public async Task<JsonResult> ChangeUser([FromBody] UserModel userModel)
        {
            if (userModel.Password != userModel.ConfirmPassword)
                return new JsonResult(new ResultModel()
                {
                    StatusCode = HttpStatusCode.InternalServerError,
                    Errors = "Senha não é igual",
                    Type = "Password",
                    IsOK = false
                });

            var result = await _userServices.ChangeUserAsync(userModel);

            return new JsonResult(new ResultModel()
            {
                StatusCode = result > 0 ? HttpStatusCode.OK : HttpStatusCode.InternalServerError,
                IsOK = true,
                Data = result,
                Redirect = "/Home"
            });
        }
    }
}
