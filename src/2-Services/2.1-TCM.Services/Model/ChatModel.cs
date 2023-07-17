using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model
{
    public class ChatModel
    {
        public int? ChatUserId { get; set; }

        public int? ChatConnectionUserId { get; set; }

        public string ChatMessage { get; set; }

        public bool ChatIsRead { get; set; }

        public DateTime? ChatCreatedDate { get; set; }

        public string ChatUserUserName { get; set; }

        public string ConnectionUserUserName { get; set; }
    }
}
