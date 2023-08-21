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
    public class BannerRepository : BaseRepository, IBannerRepository
    {
        public BannerRepository(IConfiguration configuration) : base(configuration) { }

        public async Task<IEnumerable< BannerModel>> GetBannerAsync()
        {
            var query = @"PR_Banner_Select";
            return await QueryAsync<BannerModel>(query);
        }

        public async Task<int> AddBannerAsync(BannerModel banner)
        {
            var query = @"PR_Banner_Insert";
            DynamicParameters parameters = new DynamicParameters();
            parameters.Add("@BannerTypeId", banner.BannerTypeId, System.Data.DbType.Int32);
            parameters.Add("@BannerUrl", banner.BannerUrl, System.Data.DbType.String);
            parameters.Add("@BannerRedirectTo", banner.BannerRedirectTo, System.Data.DbType.String);

            return await ExecuteAsync(query, parameters);
        }
    }
}
