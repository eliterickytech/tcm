using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;

namespace TCM.Services.Interfaces.Repository
{
    public interface IConnectionRepository
    {
        Task<int> AddConnectionAsync(ConnectionModel connectionModel);
        Task<IEnumerable<ConnectionModel>> GetConnectionAsync(ConnectionModel connectionModel);
    }
}
