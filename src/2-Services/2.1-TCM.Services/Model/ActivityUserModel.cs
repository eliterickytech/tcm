using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model
{
    public class ActivityUserModel
    {
      
        public int UserId { get; set; }

        public string UserName { get; set; }
        public int ProfileId { get; set; }
        public string ActivityDescription { get; set; }
        public DateTime ActivityDate { get; set; } 
      
    }
}
