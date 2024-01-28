using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model
{
    public class ConnectionsModel
    {
        public int Id { get; set; }

        public DateTime CreatedDate { get; set; }

        public int ConnectionStatusId { get; set; }

        public string ConnectionStatusName { get; set; }

        public int UserId { get; set; }

        public string UserName { get; set; }

        public int ConnectionProfileId { get; set; }

        public string ConnectionProfileName { get; set; }
    }
}
