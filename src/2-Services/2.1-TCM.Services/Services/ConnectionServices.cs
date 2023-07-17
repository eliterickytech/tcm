using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

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

        public async Task<List<ConnectionModel>> GetUserConnectionAsync(string userName)
        {
            var result = await _connectionRepository.GetConnectionAsync(new ConnectionModel()
            {
                UserUsername = userName
            });

            return result.ToList();
        } 

        public async Task<List<ConnectionModel>> GetConnectionAsync(int userId) 
        { 
            var result = await _connectionRepository.GetConnectionAsync(new ConnectionModel() { UserId = userId });
            return result.ToList();
        }

        public async Task<int> GetCountConnectionAsync(int userId)
        {
            var result = await GetConnectionAsync(userId);
            return result.Where(x => x.ConnectionUserConnectionStatusId == 2).Count();  
        }
    }
}
