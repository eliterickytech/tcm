using System.Collections.Generic;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Models
{
    public class ProfileViewModel
    {
        public List<BannerModel> BannersModel { get; set; } = new List<BannerModel>();

        public List<CollectionModel> CollectionsModel { get; set; } = new List<CollectionModel>();

        public List<CollectionItemModel> CollectionsItemModel { get; set; } = new List<CollectionItemModel>();

        public List<CollectionItemUserModel> CollectionItemUsersModel { get; set; } = new List<CollectionItemUserModel>();

        public int Id { get; set; }

        public int ConnectionMulti { get; set; } = 0;
    }
}

