using System.Collections.Generic;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Models
{
    public class HomeViewModel
    {
        public List<BannerModel> BannersModel { get; set; } = new List<BannerModel>();

    }
}
