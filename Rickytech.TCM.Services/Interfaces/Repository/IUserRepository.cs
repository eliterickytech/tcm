using Rickytech.TCM.Services.Model;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Rickytech.TCM.Services.Interfaces.Repository
{
    public interface IUserRepository
    {
        Task<UserModel> GetUserAsync(string user, string password);
    }
}
