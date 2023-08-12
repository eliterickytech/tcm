using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model
{
    public class CollectionItemSharedModel
    {
        public int? Id { get; set; }

        public int? CollectionItemId { get; set; }

        public int? ConnectionUserId { get; set; }

        public int? UserId { get; set; }
    }
}
