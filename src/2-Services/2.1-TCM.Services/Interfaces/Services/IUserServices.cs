using TCM.Services.Model;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Interfaces.Services
{
    public interface IUserServices
    {
        Task<int> AddAdmAsync(int id);
        Task<int> AddUserAsync(UserModel userModel);
        Task<int> ChangeUserAsync(UserModel userModel);
        Task<int> ChangeUserPasswordAsync(int userId, string password);
        Task<int> DeleteUserAsync(int id);
        Task<DateTime> GetLastAccessDateAsync(int userId);
        Task<UserModel> GetLoginAsync(string user, string password);
        Task<IEnumerable<UserModel>> GetUserAsync(UserModel user);
        Task<IEnumerable<UserModel>> ListUserAsync();
        Task<int> UpdateLastAccessDateAsync(int userId);
        Task<int> UpdateUserEnabledAsync(int userId, int enabled);

        Task<IEnumerable<UserModel>> GetAllUsersAsync(UserModel user);

    }
}
