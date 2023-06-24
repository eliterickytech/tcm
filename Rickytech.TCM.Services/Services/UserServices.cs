
using System.Threading.Tasks;
using Rickytech.TCM.Services.Interfaces.Repository;
using Rickytech.TCM.Services.Interfaces.Services;
using Rickytech.TCM.Services.Model;
using Microsoft.Extensions.Configuration;

namespace Rickytech.TCM.Services.Services
{
    public class UserServices : IUserServices
    {
        private readonly IUserRepository _userRepository;
        private readonly IConfiguration _configuration;

        public UserServices(IUserRepository userRepository, IConfiguration configuration)
        {
            _userRepository = userRepository;
            _configuration = configuration;
        }

        public async Task<UserModel> GetUserAsync(string user, string password)
        {
            return await _userRepository.GetUserAsync(user, password);
        }
    }
}
