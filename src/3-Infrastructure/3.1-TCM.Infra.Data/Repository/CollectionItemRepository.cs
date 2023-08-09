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
    public class CollectionItemRepository : BaseRepository, ICollectionItemRepository
    {

        public CollectionItemRepository(IConfiguration configuration) : base(configuration)
        {

        }

        public async Task<int> AddCollectionItemAsync(CollectionItemModel model)
        {
            var query = @"PR_CollectionItem_Insert";

            var parameters = new DynamicParameters();
            parameters.Add("@CollectionId", model.CollectionItemTypeId, System.Data.DbType.Int32);
            parameters.Add("@CollectionItemTypeId", model.CollectionItemTypeName, System.Data.DbType.Int32);
            parameters.Add("@Sort", model.Sort, System.Data.DbType.Int32);
            parameters.Add("@Url", model.Url, System.Data.DbType.String);
            parameters.Add("@Description", model.Description, System.Data.DbType.String);

            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<IEnumerable<CollectionItemModel>> GetCollectionItemAsync(int collectionId)
        {
            var query = @"PR_CollectionItem_Select";

            var parameters = new DynamicParameters();
            parameters.Add("CollectionId", collectionId, System.Data.DbType.Int32);

            try
            {
                var result = await QueryAsync<CollectionItemModel>(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<CollectionItemModel> GetCollectionItemDetailsAsync(int id)
        {
            var query = @"PR_CollectionItem_Select";

            var parameters = new DynamicParameters();
            parameters.Add("CollectionItemId", id, System.Data.DbType.Int32);

            try
            {
                var result = await QueryFirstOrDefaultAsync<CollectionItemModel>(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }
    }
}
