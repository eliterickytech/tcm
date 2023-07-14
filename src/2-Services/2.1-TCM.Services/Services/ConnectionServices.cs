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

        public async Task<List<ConnectionModel>> GetUserConnectionAsync(string email)
        {
            var result = await _connectionRepository.GetConnectionAsync(new ConnectionModel()
            {
                UserEmail = email
            });

            return result.ToList();
        } 
    }
}
