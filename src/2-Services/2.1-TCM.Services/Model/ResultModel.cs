using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model
{
    public class ResultModel
    {
        public int StatusCode { get; set; }

        public bool IsOK { get; set; }

        public string Errors { get; set; }

        public object Data { get; set; }
    }
}
