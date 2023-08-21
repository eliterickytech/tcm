
using System.Threading.Tasks;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using Microsoft.Extensions.Configuration;
using System.Collections;
using System.Collections.Generic;

namespace TCM.Services.Services
{
    public class UserServices : IUserServices
    {
        private readonly IUserRepository _userRepository;

        public UserServices(IUserRepository userRepository)
        {
            _userRepository = userRepository;
        }

        public async Task<UserModel> GetLoginAsync(string user, string password) => await _userRepository.GetLoginAsync(user, password);

        public async Task<IEnumerable<UserModel>> GetUserAsync(UserModel user) => await _userRepository.GetUserAsync(user);

        public async Task<int> AddUserAsync(UserModel userModel) => await _userRepository.AddUserAsync(userModel);

        public async Task<int> ChangeUserAsync(UserModel userModel) => await _userRepository.ChangeUserAsync(userModel);

        public async Task<int> DeleteUserAsync(int id) => await _userRepository.DeleteAdmAsync(id);

        public async Task<int> AddAdmAsync(int id) => await _userRepository.AddAdmAsync(id);

    }
}
