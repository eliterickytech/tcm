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
    public class CollectionItemUserRepository : BaseRepository, ICollectionItemUserRepository
    {
        public CollectionItemUserRepository(IConfiguration configuration) : base(configuration)
        {

        }
        public async Task<IEnumerable<int>> GetCollectionItemUserAsync(int collectionid, int userId)
        {
            var query = @"PR_CollectionItemUser_Select";

            var parameters = new DynamicParameters();
            parameters.Add("@CollectionId", collectionid, System.Data.DbType.Int32);
            parameters.Add("@UserId", userId, System.Data.DbType.Int32);

            try
            {
                var result = await QueryAsync<int>(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<IEnumerable<CollectionItemUserModel>> GetCollectionItemUserByUserIdCollectionIdAsync(int collectionid, int userId)
        {
            var query = @"PR_CollectionItemUser_Select";

            var parameters = new DynamicParameters();
            parameters.Add("@CollectionId", collectionid, System.Data.DbType.Int32);
            parameters.Add("@UserId", userId, System.Data.DbType.Int32);

            try
            {
                var result = await QueryAsync<CollectionItemUserModel>(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }
        
    }
}
