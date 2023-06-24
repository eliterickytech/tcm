using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Net.Mail; //Added for using MailMessage class  
using System.Net; //Added for using NetworkCredential class 
using Microsoft.Extensions.Configuration;
using Rickytech.TCM.Services.Model;

namespace Rickytech.CrossCutting.Helpers
{
    public class SendMail
    {
        public IConfiguration Configuration { get; }
        public SendMail(IConfiguration configuration)
        {
            Configuration = configuration;
        }

        public async Task SendCodeAsync()
        {
            MailMessage mail = new MailMessage();
            SmtpClient smtpClient = new SmtpClient();

            SMTPConfiguration configuration = new SMTPConfiguration();
            mail.IsBodyHtml = true;
        }
    }
}
