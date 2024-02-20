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
    public class ActivityUserRepository : BaseRepository, IActivityUserService
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

        public async Task<int> InsertActivityUserAsync(int userId, string description)
        {
            var query = @"PR_ActivityUser_Insert";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", userId, System.Data.DbType.Int32);
            parameters.Add("@ActionDescription", description, System.Data.DbType.String);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<int> InsertActivityUserIterationAsync(int userId, int activityUserId, int typeId)
        {
            var query = "PR_ActivityUser_Iteration_Insert";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", userId, System.Data.DbType.Int32);
            parameters.Add("@ActivityUserId", activityUserId, System.Data.DbType.Int32);
            parameters.Add("@TypeId", typeId, System.Data.DbType.Int32);

            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;
            }
            catch (Exception ex) { return default; }
        }

        public async Task<int> DeleteActivityUserIterationAsync(int activityUserId, int userId, int typeId)
        {
            var query = "PR_ActivityUser_Iteration_Delete";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", userId, System.Data.DbType.Int32);
            parameters.Add("@ActivityUserId", activityUserId, System.Data.DbType.Int32);
            parameters.Add("@TypeId", typeId, System.Data.DbType.Int32);

            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;
            }
            catch (Exception ex) { return default; }
        }

        public async Task<int> CountActivityUserIterationAsync(int activityUserId)
        {
            var query = "PR_ActivityUser_Iteration_Select";

            var parameters = new DynamicParameters();
            parameters.Add("@ActivityUserId", activityUserId, System.Data.DbType.Int32);

            try
            {
                var result = (await QueryAsync<int>(query, parameters))?.FirstOrDefault();
                return result ?? 0;
            }
            catch (Exception ex) { return default; }
        }
    }
}
