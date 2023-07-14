using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;

namespace TCM.Services.Interfaces.Repository
{
    public interface IBannerRepository
    {
        Task<IEnumerable<BannerModel>> GetBannerAsync();
    }
}
