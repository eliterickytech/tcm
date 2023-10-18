using System;

namespace TCM.Presentation.Site.Models
{
    public class ActivityModel
    {
        public int UserId { get; set; }

        public string UserName { get; set; }
        public int ProfileId { get; set; }
        public string ActivityDescription { get; set; }
        public DateTime ActivityDate { get; set; }
    }
}
