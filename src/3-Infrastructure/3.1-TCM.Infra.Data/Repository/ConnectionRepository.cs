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
    public class ConnectionRepository : BaseRepository, IConnectionRepository
    {

        public ConnectionRepository(IConfiguration configuration) : base(configuration)
        {

        }
        public async Task<int> UpdateStatusConnectionAsync(int id,  int ConnectionStatusId)
        {
            var query = "PR_Connection_Status_Update";

            var parameters = new DynamicParameters();
            parameters.Add("Id", id, System.Data.DbType.Int32);
            parameters.Add("ConnectionStatusId", ConnectionStatusId, System.Data.DbType.Int32);

            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }


        public async Task<int> DeleteConnectionAsync(int id, int connectionStatusId)
        {
            var query = "PR_Connection_Delete";

            var parameters = new DynamicParameters();
            parameters.Add("Id", id, System.Data.DbType.Int32);
            parameters.Add("ConnectionStatusId", connectionStatusId, System.Data.DbType.Int32);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }
        public async Task<int> AddConnectionAsync(ConnectionModel connectionModel)
        {
            var query = @"PR_Connection_Insert";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", connectionModel.UserId, System.Data.DbType.Int32);
            parameters.Add("@ConnectionUserId", connectionModel.ConnectionUserId, System.Data.DbType.Int32);
            parameters.Add("@ConnectionStatusId", connectionModel.ConnectionUserConnectionStatusId, System.Data.DbType.Int32);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }
        
        public async Task<IEnumerable<ConnectionsModel>> ListConnectionsByUserIdAsync(int userId, int connectionUserId)
        {
            var query = @"PR_Connections_User_Select";

            var parameters = new DynamicParameters();
            if (userId > 0)
                parameters.Add("@UserId", userId, System.Data.DbType.Int32);

            if (connectionUserId > 0)
                parameters.Add("@ConnectionUserId", connectionUserId, System.Data.DbType.Int32);


            try
            {
                var result = await QueryAsync<ConnectionsModel>(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<IEnumerable<ConnectionsModel>> ListConnectionsByConnectionUserIdAsync(int userId, int connectionUserId)
        {
            var query = @"PR_Connections_Connection_Select";

            var parameters = new DynamicParameters();
            if (userId > 0)
                parameters.Add("@UserId", userId, System.Data.DbType.Int32);

            if (connectionUserId > 0)
                parameters.Add("@ConnectionUserId", connectionUserId, System.Data.DbType.Int32);


            try
            {
                var result = await QueryAsync<ConnectionsModel>(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<IEnumerable<ConnectionModel>> GetConnectionAsync(ConnectionModel connectionModel)
        {
            var query = @"PR_Connection_Select";

            var parameters = new DynamicParameters();
            parameters.Add("@Id", connectionModel.ConnectionUserId, System.Data.DbType.Int32);
            parameters.Add("@UserId", connectionModel.UserId, System.Data.DbType.Int32);
            parameters.Add("@ConnectionUserId", connectionModel.UserConnectionId, System.Data.DbType.Int32);
            parameters.Add("@ConnectionStatusId", connectionModel.ConnectionUserConnectionStatusId, System.Data.DbType.Int32);
            parameters.Add("@Email", connectionModel.UserEmail, System.Data.DbType.String);
            parameters.Add("@UserName", connectionModel.UserUsername, System.Data.DbType.String);


            try
            {
                var result = await QueryAsync<ConnectionModel>(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<IEnumerable<int>> GetConnectionBlockedAsync(int userId, int? connectionUserId)
        {
            var query = @"PR_Connection_StatusBlocked_Select";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", userId, System.Data.DbType.Int32);

            if (connectionUserId.HasValue)
                parameters.Add("@ConnectionUserId", connectionUserId, System.Data.DbType.Int32);

            try
            {
                var result = await QueryAsync<int>(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<int> AddConnectionBlockedAsync(int userId, int connectionUserId)
        {
            var query = @"PR_Connection_StatusBlocked_Insert";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", userId, System.Data.DbType.Int32);
            parameters.Add("@ConnectionUserId", connectionUserId, System.Data.DbType.Int32);

            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<int> DeleteConnectionBlockedAsync(int userId, int connectionUserId)
        {
            var query = @"PR_Connection_StatusBlocked_Delete";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", userId, System.Data.DbType.Int32);
            parameters.Add("@ConnectionUserId", connectionUserId, System.Data.DbType.Int32);

            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }
    }
}
