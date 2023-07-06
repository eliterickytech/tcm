
using System.Threading.Tasks;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using Microsoft.Extensions.Configuration;

namespace TCM.Services.Services
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
