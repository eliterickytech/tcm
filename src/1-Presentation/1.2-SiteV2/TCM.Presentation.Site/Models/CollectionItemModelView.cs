using System.Collections.Generic;

namespace TCM.Presentation.Site.Models
{
    public class CollectionItemModelView
    {
        public int CollectionId { get; set; }

        public List<CollectionItem> CollectionItems { get; set; }

    }

    public class CollectionItem
    {
        public int CollectionItemTypeId { get; set; }

        public string Url { get; set; }

        public int Sequence { get; set; }

        public int Sort { get; set; }

        public int Quantity { get; set; }

        public string Description { get; set; }
    }
}
