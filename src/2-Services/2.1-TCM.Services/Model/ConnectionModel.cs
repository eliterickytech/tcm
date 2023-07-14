using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model
{
    public class ConnectionModel
    {

        public int? Id { get; set; } = null;

        public int? UserId { get; set; } = null;

        public string? UserFullName { get; set; } = null;

        public string? UserEmail { get; set; } = null;

        public string? UserUsername { get; set; } = null;

        public string? UserMobilePhone { get; set; } = null;

        public int? ConnectionUserId { get; set; } = null;

        public int? ConnectionUserConnectionStatusId { get; set; } = null;

        public DateTime? ConnectionUserCreatedDate { get; set; } = null;

        public string? ConnectionStatusUserName { get; set; } = null;

        public int? UserConnectionId { get; set; } = null;

        public string? UserConnectionFullName { get; set; } = null;

        public string? UserConnectionEmail { get; set; } = null;

        public string? UserConnectionUsername { get; set; } = null;

        public string? UserConnectionMobilePhone { get; set; } = null;  

    }
}
