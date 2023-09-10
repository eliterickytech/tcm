using Dapper;
using Microsoft.Extensions.Configuration;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Infra.Repository;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Model;

namespace TCM.Infrastructure.Data.Repository
{
    public class CollectionRepository : BaseRepository, ICollectionRepository
    {

        public CollectionRepository(IConfiguration configuration) : base(configuration)
        {

        }



        public async Task<int> AddCollectionAsync(CollectionModel model)
        {
            var query = @"PR_Collection_Insert";

            var parameters = new DynamicParameters();
            parameters.Add("CollectionTypeId", model.CollectionTypeId, System.Data.DbType.Int32);
            parameters.Add("Name", model.CollectionName, System.Data.DbType.String);
            parameters.Add("AvailableDate", model.AvailableDate, System.Data.DbType.DateTime);
            parameters.Add("IsPhysicalAward", model.IsPhysicalAward, System.Data.DbType.Boolean);
            try
            {
                var result = await ExecuteScalarAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<int> UpdatedCollectionAsync(CollectionModel model)
        {
            var query = @"PR_Collection_Update";

            var parameters = new DynamicParameters();
            parameters.Add("CollectionId", model.Id, System.Data.DbType.Int32);
            parameters.Add("CollectionTypeId", model.CollectionTypeId, System.Data.DbType.Int32);
            parameters.Add("Name", model.CollectionName, System.Data.DbType.String);
            parameters.Add("AvailableDate", model.AvailableDate, System.Data.DbType.DateTime);
            parameters.Add("IsPhysicalAward", model.IsPhysicalAward, System.Data.DbType.Boolean);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<IEnumerable<CollectionModel>> GetCollectionAsync()
        {
            var query = @"PR_Collection_Select";


            try
            {
                var result = await QueryAsync<CollectionModel>(query);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<IEnumerable< CollectionTypeModel>> GetCollectionTypeAsync()
        {
            var query = @"PR_CollectionType_Select";

            var parameters = new DynamicParameters();

            try
            {
                var result = await QueryAsync<CollectionTypeModel>(query);
                return result;

            }
            catch (Exception ex) { return default; }
            
        }

        public async Task<int> RemoveCollectionAsync(int id)
        {
            var query = @"PR_Collection_Delete";

            var parameters = new DynamicParameters();
            parameters.Add("Id", id, System.Data.DbType.Int32);

            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }
    }
}
