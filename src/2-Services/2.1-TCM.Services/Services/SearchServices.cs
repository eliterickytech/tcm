using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using TCM.Services.Model.Enum;

namespace TCM.Services.Services
{
    public class SearchServices : ISearchServices
    {
        private readonly IUserServices _userServices;
        private readonly ICollectionServices _collectionServices;
        private readonly IConnectionServices _connectionServices;

        public SearchServices(IUserServices userServices, ICollectionServices collectionServices, IConnectionServices connectionServices )
        {
            _userServices = userServices;
            _collectionServices = collectionServices;
            _connectionServices = connectionServices;
        }

        public async Task<List<ResultSearchModel>> SearchUserAsync(string search, int userId)
        {
            var users = await _userServices.GetUserAsync(new UserModel() { UserName = search });

            if (!users.Any()) users = await _userServices.GetUserAsync(new UserModel() { Email = search });

            if (!users.Any()) users = await _userServices.GetUserAsync(new UserModel() { FullName = search });
            
            var resultSearchModels = new List<ResultSearchModel>();

            foreach (var user in users)
            { 
                var collection = await _collectionServices.GetCountCollectionCompletedAsync(user.Id.Value);

                var connections = await _connectionServices.GetConnectionAsync(userId);

                resultSearchModels.Add(new ResultSearchModel()
                {
                    Username = user.UserName,
                    CountCollection = collection,
                    ConnectionStatus = connections?.Where(x => x.UserId == user.Id || x.UserConnectionId == user.Id).FirstOrDefault()?.ConnectionUserConnectionStatusId,
                    ConnectionUserId = user.Id,
                    IsConnection = connections.Where(x => x.UserConnectionId == user.Id).Any()
                });
            };

            return resultSearchModels;

        }

    }
}
