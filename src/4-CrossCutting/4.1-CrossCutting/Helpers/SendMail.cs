

using System;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Mail;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using Azure.Communication.Email;
using Microsoft.AspNetCore.Hosting;
using Newtonsoft.Json.Linq;
using SendGrid;
using SendGrid.Helpers.Mail;
using TCM.CrossCutting.Model;
using TCM.CrossCutting.Models;

namespace TCM.CrossCutting.Helpers
{
    public class SendMail
    {
        private readonly IWebHostEnvironment _webHostEnvironment;
        private readonly SMTPConfiguration _smtpConfiguration;
        public SendMail(SMTPConfiguration smtpConfiguration, IWebHostEnvironment webHostEnvironment)
        {
            _smtpConfiguration = smtpConfiguration;
            _webHostEnvironment = webHostEnvironment;
        }

        public async Task SendRememberPasswordAsync(string mailTo, string token, string username)
        {

            string root = _webHostEnvironment.ContentRootPath;

            var connectionString = _smtpConfiguration.ConnectionString;

            var emailClient = new EmailClient(connectionString);

            var plainTextContent = Regex.Replace(ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLRememberPassword)).ToString().Replace("@url@", token).Replace("@username@", username), "<[^>]*>", "");


            EmailSendOperation emailSendOperation = await emailClient.SendAsync(Azure.WaitUntil.Completed,
                senderAddress: _smtpConfiguration.Mail,
                recipientAddress: mailTo,
                subject: "Team Chef Melo - Remmember password - DoNotReply",
                htmlContent: ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLRememberPassword)).ToString().Replace("@url@", token).Replace("@username@", username),
                null);

        }

        public async Task SendCodeAsync(string mailTo, string code)
         {
            string root = _webHostEnvironment.ContentRootPath;

            var connectionString = _smtpConfiguration.ConnectionString;

            var emailClient = new EmailClient(connectionString);

            var plainTextContent = Regex.Replace(ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLVerification)).ToString().Replace("@AccessCode@", code), "<[^>]*>", "");


            EmailSendOperation emailSendOperation = await emailClient.SendAsync(Azure.WaitUntil.Completed,
                senderAddress: _smtpConfiguration.Mail,
                recipientAddress: mailTo,
                subject: _smtpConfiguration.SubjectVerification,
                htmlContent: ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLVerification)).ToString().Replace("@AccessCode@", code),
                plainTextContent: plainTextContent);
        }

        public async Task SendWelcomeAsync(string mailTo, string fullname)
        {
            string root = _webHostEnvironment.ContentRootPath;

            var connectionString = _smtpConfiguration.ConnectionString;

            var emailClient = new EmailClient(connectionString);

            var plainTextContent = Regex.Replace(ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLWelcome)).ToString().Replace("@fullname@", fullname), "<[^>]*>", "");


            EmailSendOperation emailSendOperation = await emailClient.SendAsync(Azure.WaitUntil.Completed,
                senderAddress: _smtpConfiguration.Mail,
                recipientAddress: mailTo,
                subject: _smtpConfiguration.SubjectWelcome,
                htmlContent: ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLWelcome)).ToString().Replace("@fullname@", fullname),
                plainTextContent: plainTextContent);
                
        }
        private string ReadHtmlFile(string filePath)
        {
            using (StreamReader sr = new StreamReader(filePath))
            {
                return sr.ReadToEnd();
            }
        }
    }
}
