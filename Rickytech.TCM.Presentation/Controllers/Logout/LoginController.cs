using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using Rickytech.CrossCutting.Helpers;
using Rickytech.TCM.Services.Interfaces.Services;
using Rickytech.TCM.Services.Model;
using System;
using System.Threading.Tasks;

namespace Rickytech.TCM.Presentation.Controllers.Logout
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

        public async Task<UserModel> GetUser(string user, string password)
        {
            var result = await _userServices.GetUserAsync(user, password);
            
            if (result is null) return default;

            var code = Code.GeneratedCode(6);

            var resultCode = await _codeServices.SaveCodeAsync(user, code);

            if (result.ProfileId == Profile.User)
                result.Redirect = GeneratedToken(user, code);

            return result;
        }

        private string GeneratedToken(string user, string code)
        {
            var url = $"Code/Mobile?";

            var param = $"user={user}&code={code}";

            return $"{url}token={Encrypt.EncodeBase64(param)}";
        }
    }
}
