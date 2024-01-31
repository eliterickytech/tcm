using Microsoft.AspNetCore.Mvc;
using System.Linq;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class SearchController : Controller
    {
        private readonly IUserServices _userServices;
        private readonly IConnectionServices _connectionServices;

        public SearchController(IUserServices userServices, IConnectionServices connectionServices)
        {
            _userServices = userServices;
            _connectionServices = connectionServices;
        }

        public IActionResult Index()
        {
            return View();
        }

        public async Task<IActionResult> SearchUser(string username)
        {
            var currentUser = _userServices.CurrentUserAsync();

            if (currentUser.Id == 0) return RedirectToAction("Index", "Login");

            var users = await _userServices.GetUserAsync(new UserModel() { UserName = username });

            if (!users.Any())
            {
                users = await _userServices.GetUserAsync(new UserModel() { Email = username });
            }

            if (users.Any()) 
            {

                var connectionAll = await _connectionServices.GetConnectionAsync(new ConnectionModel()
                {
                    UserId = currentUser.Id,
                    UserConnectionId = users.FirstOrDefault().Id
                });

                if (username.ToLower() == currentUser.UserName.ToLower())
                {
                    users = new System.Collections.Generic.List<UserModel>();
                }

                if (connectionAll.Any())
                {
                    users = new System.Collections.Generic.List<UserModel>();
                }
            }

            return View(users);
        }
    }
}
