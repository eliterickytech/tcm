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

        public async Task<int> AddConnectionAsync(ConnectionModel connectionModel)
        {
            var query = @"PR_Connection_Insert";

            var parameters = new DynamicParameters();
            parameters.Add("@User", connectionModel.UserId, System.Data.DbType.Int32);
            parameters.Add("@ConnectionUserId", connectionModel.ConnectionUserId, System.Data.DbType.Int32);
            parameters.Add("@ConnectionStatusId", connectionModel.ConnectionUserConnectionStatusId, System.Data.DbType.Int32);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<IEnumerable<ConnectionModel>> GetConnectionAsync(ConnectionModel connectionModel)
        {
            var query = @"PR_Connection_Select";

            var parameters = new DynamicParameters();
            parameters.Add("@Id", connectionModel.Id, System.Data.DbType.Int32);
            parameters.Add("@UserId", connectionModel.UserId, System.Data.DbType.Int32);
            parameters.Add("@ConnectionUserId", connectionModel.ConnectionUserId, System.Data.DbType.Int32);
            parameters.Add("@ConnectionStatusId", connectionModel.UserConnectionId, System.Data.DbType.Int32);
            parameters.Add("@Email", connectionModel.UserEmail, System.Data.DbType.String);
            parameters.Add("@UserName", connectionModel.UserUsername, System.Data.DbType.String);


            try
            {
                var result = await QueryAsync<ConnectionModel>(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }
    }
}
