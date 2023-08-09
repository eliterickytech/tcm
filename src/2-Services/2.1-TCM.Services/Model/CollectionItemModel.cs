using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model
{
    public class CollectionItemModel
    {
        public int Id { get; set; }
        public int CollectionId { get; set; }

        public int CollectionItemTypeId { get; set; }

        public string CollectionItemTypeName { get; set; }

        public int CollectionItemTypeWidth { get; set; }

        public int CollectionItemTypeHeigh { get; set; }

        public string Description { get; set; }

        public int Sort { get; set; }

        public string Url { get; set; }

        public DateTime CreatedDate { get; set; }

        public bool CollectionItemTypeIsCollectible { get; set; }

        public bool Enabled { get; set; }

        public string CollectionItemName { get; set; }

        public int Quantity { get; set; }
    }
   
}
