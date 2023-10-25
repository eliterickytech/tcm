using System.Collections.Generic;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Models
{
    public class CommunityModel
    {
        public List<BannerModel> BannersModel { get; set; } = new List<BannerModel>();
        public List<CollectionModel> CollectionsModel { get; set; } = new List<CollectionModel>();

        public List<CollectionItemModel> CollectionsItemModel { get; set; } = new List<CollectionItemModel>();

        public int Id { get; set; }

        public int CountUnreadChats { get; set; } 
    }
}
