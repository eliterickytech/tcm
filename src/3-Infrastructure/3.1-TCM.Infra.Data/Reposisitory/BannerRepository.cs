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

namespace TCM.Infrastructure.Data.Reposisitory
{
    public class BannerRepository : BaseRepository, IBannerRepository
    {
        public BannerRepository(IConfiguration configuration) : base(configuration) { }

        public async Task<IEnumerable< BannerModel>> GetBannerAsync()
        {
            var query = @"PR_Banner_Select";
            return await QueryAsync<BannerModel>(query);
        }
    }
}
