using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model
{
    public class ResultModel
    {
        public HttpStatusCode StatusCode { get; set; }

        public bool IsOK { get; set; }

        public string Errors { get; set; }

        public string Type { get; set; }

        public object Data { get; set; }

        public string Redirect { get; set; }
    }
}
