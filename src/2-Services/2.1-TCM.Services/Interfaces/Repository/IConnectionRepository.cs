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
        Task<int> AddConnectionAsync(ConnectionModel connectionUser);
        Task<int> AddConnectionBlockedAsync(int userId, int connectionUserId);
        Task<int> DeleteConnectionAsync(int id, int connectionStatusId);
        Task<int> DeleteConnectionBlockedAsync(int userId, int connectionUserId);
        Task<IEnumerable<ConnectionModel>> GetConnectionAsync(ConnectionModel connectionModel);
        Task<IEnumerable<int>> GetConnectionBlockedAsync(int userId, int? connectionUserId);
        Task<IEnumerable<ConnectionsModel>> ListConnectionsByConnectionUserIdAsync(int userId, int connectionUserId);
        Task<IEnumerable<ConnectionsModel>> ListConnectionsByUserIdAsync(int userId, int connectionUserId);
        Task<int> UpdateStatusConnectionAsync(int id, int ConnectionStatusId);
    }
}
