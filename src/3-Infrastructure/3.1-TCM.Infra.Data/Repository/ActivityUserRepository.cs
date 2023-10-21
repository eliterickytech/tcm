using Dapper;
using Microsoft.Extensions.Configuration;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Infra.Repository;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Model;

namespace TCM.Infrastructure.Data.Repository
{
    public class ActivityUserRepository : BaseRepository, IActivityUserRepository
    {
        public ActivityUserRepository(IConfiguration configuration) : base(configuration)
        {

        }

        public async Task<IEnumerable<ActivityUserModel>> GetActivityFriendUserAsync(int userId)
        {
            var query = @"PR_ActivityFriendsUser_Select";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", userId, System.Data.DbType.Int32);

            try
            {
                var result = await QueryAsync<ActivityUserModel>(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<IEnumerable<ActivityUserModel>> GetActivityUserAsync(int collectionid, int userId)
        {
            var query = @"PR_ActivityUser_Select";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", userId, System.Data.DbType.Int32);

            try
            {
                var result = await QueryAsync<ActivityUserModel>(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public Task<IEnumerable<ActivityUserModel>> GetActivityUserAsync(int userId)
        {
            throw new NotImplementedException();
        }

        public Task<int> InsertActivityUserAsync(int userId, string description)
        {
            throw new NotImplementedException();
        }

        public async Task<int> InsertCollectionItemUserAsync(int collectionId, int collectionItemId, int userId)
        {
            var query = @"PR_ActivityUser_Insert";

            var parameters = new DynamicParameters();
            parameters.Add("@UsersId", userId, System.Data.DbType.Int32);
            parameters.Add("@ActionDescription", userId, System.Data.DbType.String);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        
    }
}
