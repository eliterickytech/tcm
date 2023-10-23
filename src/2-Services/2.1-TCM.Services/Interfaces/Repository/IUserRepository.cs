using TCM.Services.Model;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Interfaces.Repository
{
    public interface IUserRepository
    {
        Task<int> AddAdmAsync(int userId);
        Task<int> AddUserAsync(UserModel userModel);
        Task<int> ChangeUserAsync(UserModel userModel);
        Task<int> DeleteAdmAsync(int userId);
        Task<DateTime> GetLastAccessDateAsync(int userId);
        Task<UserModel> GetLoginAsync(string user, string password);
        Task<IEnumerable<UserModel>> GetUserAsync(UserModel user);
        Task<IEnumerable<UserModel>> ListUserAsync();
        Task<int> UpdateLastAccessDateAsync(int userId);
    }
}
