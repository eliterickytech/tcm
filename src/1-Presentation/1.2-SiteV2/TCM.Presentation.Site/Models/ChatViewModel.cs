using System;

namespace TCM.Presentation.Site.Models
{
    public class ChatViewModel
    {
        public int Id { get; set; }

        public int UserId { get; set; }

        public int ConnectionUserId { get; set; }

        public string Username { get; set; }

        public string Message { get; set; }

        public DateTime DateMessage { get; set; }

        public int CountUnread { get; set; }    

        public bool IsUnread { get; set; }

        public bool Question { get; set; }
         
    }
}
