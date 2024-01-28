using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.CrossCutting.Model
{
    public class SMTPConfiguration
    {
        public string Domain { get; set; }  
        public string Host { get; set; }
        public int Port { get; set; } = 587;
        public string UserName { get; set; }
        public string Password { get; set; }
        public string HTMLRememberPassword { get; set; }
        public string SubjectVerification { get; set; }

        public string SubjectWelcome { get; set; }
        public string Mail { get; set; }
        public string HTMLVerification { get; set; }
        public string HTMLWelcome { get; set; }

        public string ApiKey { get; set; }

        public string ConnectionString { get; set; }

        public SMTPConfiguration() { }

    }
}

