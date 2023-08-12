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
    public class CollectionItemSharedRepository : BaseRepository, ICollectionItemSharedRepository
    {
        public CollectionItemSharedRepository(IConfiguration configuration) : base(configuration) { 
        
        }
        
        public async Task<IEnumerable<CollectionItemSharedModel>> GetCollectionItemSharedAsync(CollectionItemSharedModel model)
        {
            var query = "PR_CollectionitemShared_Select";

            DynamicParameters parameters = new DynamicParameters();
            parameters.Add("@UserId", model.Id, System.Data.DbType.Int32);
            parameters.Add("@ConnectionUserId", model.ConnectionUserId, System.Data.DbType.Int32);
            parameters.Add("@CollectionItemId", model.CollectionItemId, System.Data.DbType.Int32);

            try
            {
                var result = await QueryAsync<CollectionItemSharedModel>(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

    }
}
