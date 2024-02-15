using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model
{
    public class CollectionModel
    {
        public int Id { get; set; }

        public string CollectionName { get; set; }

        public string CollectionTypeName { get; set; }

        public int? CollectionTypeId { get; set; }

        public int CollectionTypeQuantity { get; set; }

        public DateTime? AvailableDate { get; set; }

        public bool IsPhysicalAward { get; set; } = false;

        public bool Enabled { get; set; } = true;

        public DateTime CollectionCreatedDate { get; set; } 

        public string CollectionDescription { get; set; } 
    }
}
