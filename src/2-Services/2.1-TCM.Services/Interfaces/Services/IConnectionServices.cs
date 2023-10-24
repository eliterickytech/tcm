using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;
using TCM.Services.Model.Enum;

namespace TCM.Services.Interfaces.Services
{
    public interface IConnectionServices
    {
        Task<int> AddConnectionAsync(int connectionUserId, int userId);
        Task<int> AddConnectionAsync(int userId, int connectionUserId, ConnectionStatusType connectionStatusType);
        Task<int> DeleteConnectionAsync(int id, int connectionStatusId);
        Task<List<ConnectionModel>> GetConnectionAsync(int userId);
        Task<List<ConnectionModel>> GetConnectionAsync(ConnectionModel model);
    Task<List<ConnectionModel>> GetConnectionIdAsync(ConnectionModel model);
        Task<List<ConnectionModel>> GetUserConnectionAsync(string userName);
        Task<int> UpdateStatusConnectionAsync(int id, int connectionStatusId);
    }
}
