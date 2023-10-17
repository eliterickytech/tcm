namespace TCM.Presentation.Site.Models
{
    public class FriendsActivities
    {
        public int Id { get; set; }
        public int FriendId { get; set; }
        public string FriendName { get; set; }
        public string FriendActionDescription { get; set;}

        public string FriendActionDate { get; set; }
    }
}
