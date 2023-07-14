using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Services.Services
{
    public class BannerServices : IBannerServices
    {
        private readonly IBannerRepository _bannerRepository  ;

        public BannerServices(IBannerRepository bannerRepository)
        {
            _bannerRepository = bannerRepository;
        }

        public async Task<IEnumerable<BannerModel>> GetBannerAsync() => await _bannerRepository.GetBannerAsync();
    }
}
