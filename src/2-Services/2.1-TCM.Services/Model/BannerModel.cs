using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model
{
    public class BannerModel
    {
        public int BannerId { get; set; }

        public string BannerRedirectTo { get; set; }

        public string BannerUrl { get; set; }

        public int BannerTypeId { get; set; }

        public string BannerTypeType { get; set; }

        public bool BannerVideo { get; set; }

        public int BannerTypeWidth { get; set; }

        public int BannerTypeHeight { get; set; }

        public DateTime BannerTypeCreatedDate { get; set; }

        public DateTime? BannerTypeChangedDate { get; set; }


    }
}
