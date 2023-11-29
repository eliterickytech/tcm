using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using System;
using System.Linq;
using System.Net;
using System.Security.Claims;
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

        public async Task<IActionResult> Index()
        {
            TempData["ProfileId"] = HttpContext.Session.GetString("ProfileId");

            if (!User.Identity.IsAuthenticated) return RedirectToAction("Index", "Login");

            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;

            var user = (await _userServices.GetUserAsync(new UserModel() { Id = Convert.ToInt32(id) })).FirstOrDefault();
            return View(user);
        }
        public IActionResult Change() 
        {
            return View();
        }

        public async Task<IActionResult> ChangePassword()
        {
            if (!User.Identity.IsAuthenticated) return RedirectToAction("Index", "Login");

            var id = HttpContext.User.Claims.FirstOrDefault(a => a.Type == ClaimTypes.NameIdentifier)?.Value;

            var user = (await _userServices.GetUserAsync(new UserModel() { Id = Convert.ToInt32(id) })).FirstOrDefault();
            return View("ChangePassword",user);
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

        [HttpPost]
        public async Task<JsonResult> ChangePassawordUser([FromBody] UserModel userModel)
        {
            if (userModel.Password != userModel.ConfirmPassword)
                return new JsonResult(new ResultModel()
                {
                    StatusCode = HttpStatusCode.InternalServerError,
                    Errors = "Senha não é igual",
                    Type = "Password",
                    IsOK = false
                });

            if(userModel.Id != 0) { 
            var result = await _userServices.ChangeUserPasswordAsync((int)userModel.Id, userModel.Password);
           
            return new JsonResult(new ResultModel()
            {
                StatusCode = result > 0 ? HttpStatusCode.OK : HttpStatusCode.InternalServerError,
                IsOK = true,
                Data = result,
                Redirect = "/Home"
            });
            }
            else
            {
                return new JsonResult(new ResultModel()
                {
                    StatusCode = HttpStatusCode.InternalServerError,
                    Errors = "Não foi possivel identificar o usuário",
                    Type = "Password",
                    IsOK = false
                });
            }
        }
    }
}
