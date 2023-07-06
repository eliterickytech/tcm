using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model
{
    public class CodeModel
    {
        public int Id { get; set; }

        public int UserId { get; set; }

        public string Code { get; set; }

        public DateTime CreatedDate { get; set; }
    }
}
