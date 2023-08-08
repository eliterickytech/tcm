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
        Task<int> DeleteConnectionAsync(int id, int connectionStatusId);
        Task<IEnumerable<ConnectionModel>> GetConnectionAsync(ConnectionModel connectionModel);
        Task<int> UpdateStatusConnectionAsync(int id, int ConnectionStatusId);
    }
}
