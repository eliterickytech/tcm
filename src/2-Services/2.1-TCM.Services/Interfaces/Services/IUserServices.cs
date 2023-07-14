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
        Task<int> AddUserAsync(UserModel userModel);
        Task<UserModel> GetLoginAsync(string user, string password);
        Task<IEnumerable<UserModel>> GetUserAsync(UserModel user);
    }
}
