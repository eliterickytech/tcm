using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;

namespace TCM.Services.Interfaces.Services
{
    public interface IConnectionServices
    {
        Task<List<ConnectionModel>> GetUserConnectionAsync(string email);
    }
}
