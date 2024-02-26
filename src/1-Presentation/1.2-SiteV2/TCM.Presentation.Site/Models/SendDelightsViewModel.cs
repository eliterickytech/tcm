namespace TCM.Presentation.Site.Models
{
    public class SendDelightsViewModel
    {
        public int UserId { get; set; }

        public int CollectionItemId { get; set; }

        public int ConnectionUserId { get; set; }

        public int Quantity { get; set; }

        public string ConnectionNameShared { get; set; }

        public string Url { get; set; }

        public string Description { get; set; }
    }
}
