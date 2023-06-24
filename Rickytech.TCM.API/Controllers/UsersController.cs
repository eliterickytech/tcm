using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Rickytech.TCM.Services.Interfaces.Services;
using Rickytech.TCM.Services.Model;
using System.Collections.ObjectModel;
using System.Threading.Tasks;

namespace Rickytech.TCM.API.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class UsersController : ControllerBase
    {
        private readonly IUserServices _userServices;

        public UsersController(IUserServices userServices)
        {
            _userServices = userServices;
        }

        [HttpGet]
        public async Task<IActionResult> Get(string user, string password)
        {
            var result = await _userServices.GetUserAsync(user, password);

            if (result != null)
                return Ok(result);
            else
                return BadRequest();
        }
    }
}
