using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model
{
    public class CollectionItemUserModel
    {
        public int Id { get; set; } 

        public int CollectionItemId { get; set; }

        public int CollectionId { get; set; }

        public int userId { get; set; }

        public bool Enabled { get; set; }
    }
}
