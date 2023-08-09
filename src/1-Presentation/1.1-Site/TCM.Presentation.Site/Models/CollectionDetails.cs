namespace TCM.Presentation.Site.Models
{
    public class CollectionDetails
    {
        public int Id { get; set; }

        public int CollectionId { get; set; }

        public string CollectionItemName { get; set; }

        public string CollectionItemDescription { get; set;}

        public int CollectionUserName { get; set; }

        public int CollectionUserId { get; set; }

        public string UrlImage { get; set; }

        public int Width { get; set; }

        public int Height { get; set; }

        public int Quantity { get; set; }

    }
}
