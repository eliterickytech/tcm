using System.Collections.Generic;
using System.Security.Policy;

namespace TCM.Presentation.Site.Models
{
    public class ColletionsPassToAddModel
    {
        public List<string> SplitImages { get; set; } = new List<string>();

        public string UrlOrigin { get; set; }

        public string Url { get; set; }

        public int CollectionId { get; set; }

        public string CollectionName { get; set; }

        public string CollectionDescription { get; set; }

        public int CollectionTypeId { get; set; }
    }
}
