using System;

namespace TCM.Presentation.Site.Models
{
    public class ActivityModel
    {
        public int UserId { get; set; }

        public string UserName { get; set; }
        public int ProfileId { get; set; }
        public string ActionDescription { get; set; }
        public DateTime ActionDate { get; set; }
    }
}
