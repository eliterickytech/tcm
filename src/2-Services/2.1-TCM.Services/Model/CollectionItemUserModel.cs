using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model
{
    public class CollectionItemUserModel
    {
        public int CollectionUserId { get; set; } 

        public int CollectionItemId { get; set; }

        public int CollectionId { get; set; }

        public int UserId { get; set; }

        public int Quantity { get; set; }   

        public bool Enabled { get; set; } = true;
    }
}
