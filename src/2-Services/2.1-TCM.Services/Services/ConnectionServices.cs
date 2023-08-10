using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.CompilerServices;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using TCM.Services.Model.Enum;

namespace TCM.Services.Services
{
    public class ConnectionServices : IConnectionServices
    {
        private readonly IConnectionRepository _connectionRepository;
        private readonly IUserRepository _userRepository;

        public ConnectionServices(IConnectionRepository connectionRepository, IUserRepository userRepository)
        {
            _connectionRepository = connectionRepository;
            _userRepository = userRepository;
        }

        public async Task<List<ConnectionModel>> GetUserConnectionAsync(string search)
        {
            var result = await _connectionRepository.GetConnectionAsync(new ConnectionModel() { UserUsername = search });

            if (!result.Any()) await _connectionRepository.GetConnectionAsync(new ConnectionModel() { UserConnectionEmail = search });

            if (!result.Any()) await _connectionRepository.GetConnectionAsync(new ConnectionModel() { UserConnectionFullName = search });

            return result.ToList();
        } 

        public async Task<List<ConnectionModel>> GetConnectionAsync(int userId) 
        { 
            var resultUser = await _connectionRepository.GetConnectionAsync(new ConnectionModel() { UserId = userId });

            var distinct = resultUser.Distinct(new ConnectionComparer());

            return distinct.ToList();
        }

        public async Task<List<ConnectionModel>> GetConnectionAsync(ConnectionModel model)
        {
            var resultUser = await _connectionRepository.GetConnectionAsync(model);

            var distinct = resultUser.Distinct(new ConnectionComparer());

            return distinct.ToList();
        }

        public async Task<int> AddConnectionAsync(int userId, int connectionUserId)
        {
            return await _connectionRepository.AddConnectionAsync(new ConnectionModel() { UserId = userId, ConnectionUserId = connectionUserId, ConnectionUserConnectionStatusId = (int) ConnectionStatusType.Requested });

        }

        public async Task<int> UpdateStatusConnectionAsync(int id, int connectionStatusId) => await _connectionRepository.UpdateStatusConnectionAsync(id, connectionStatusId);

        public async Task<int> DeleteConnectionAsync(int id, int connectionStatusId) => await _connectionRepository.DeleteConnectionAsync(id, connectionStatusId);
    }
}

public class ConnectionComparer : IEqualityComparer<ConnectionModel>
{
    public bool Equals(ConnectionModel x, ConnectionModel y)
    {
        if (x == null || y == null)
            return false;

        return x.ConnectionUserId == y.ConnectionUserId && x.UserConnectionUsername == y.UserConnectionUsername;
    }

    public int GetHashCode(ConnectionModel obj)
    {
        return obj.ConnectionUserId.GetHashCode() ^ obj.UserConnectionUsername.GetHashCode();
    }
}
