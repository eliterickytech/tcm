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
        Task<int> DeleteUserAsync(int id);
        Task<UserModel> GetLoginAsync(string user, string password);
        Task<IEnumerable<UserModel>> GetUserAsync(UserModel user);
    }
}
