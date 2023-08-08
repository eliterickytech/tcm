using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model.Enum;

namespace TCM.Services.Model
{
    public class ResultSearchModel
    {
        public int ConnectionId { get; set; } = 0;
        public string Username { get; set; }

        public int? ConnectionUserId { get; set; }

        public int CountCollection { get; set; } = 0;

        public bool IsConnection { get; set; } = false;

        public int? ConnectionStatus { get; set; }

    }
}
