

using System;
using System.IO;
using System.Net;
using System.Net.Mail;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Hosting;
using Newtonsoft.Json.Linq;
using SendGrid;
using SendGrid.Helpers.Mail;
using TCM.CrossCutting.Model;

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

        public async Task SendCodeAsync(string mailTo, string code)
        {
            string root = _webHostEnvironment.WebRootPath;

            var sendGridClient = new SendGridClient(_smtpConfiguration.ApiKey);

            var from = new EmailAddress(_smtpConfiguration.Mail);

            var to = new EmailAddress(mailTo);

            var plainTextContent = Regex.Replace(ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLVerification)).ToString().Replace("@AccessCode@", code), "<[^>]*>", "");

            var msg = MailHelper.CreateSingleEmail(from, to, _smtpConfiguration.SubjectVerification, plainTextContent, ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLVerification)).ToString().Replace("@AccessCode@", code));

            var response = await sendGridClient.SendEmailAsync(msg);

            if (response.StatusCode != HttpStatusCode.Accepted)
            {
                throw new Exception(response.StatusCode.ToString() + ": " + response.Body);
            }
        }
        //public void SendCode(string mailTo, string code)
        //{
        //    string root = _webHostEnvironment.WebRootPath;

        //    MailMessage message = new MailMessage();

        //    message.From = new MailAddress(_smtpConfiguration.Mail);

        //    message.To.Add(mailTo);

        //    message.Subject = _smtpConfiguration.SubjectVerification;

        //    var plainTextContent = Regex.Replace(ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLVerification)).ToString().Replace("@AccessCode@", code), "<[^>]*>", "");

        //    message.Body = plainTextContent;

        //    message.IsBodyHtml = true;

        //    SmtpClient smtpClient = new SmtpClient(_smtpConfiguration.Host, _smtpConfiguration.Port);

        //    smtpClient.EnableSsl = true;

        //    smtpClient.UseDefaultCredentials = false;

        //    smtpClient.Send(message);


        //}


        public async Task SendWelcomeAsync(string mailTo, string fullname)
        {
            string root = _webHostEnvironment.WebRootPath;

            var sendGridClient = new SendGridClient(_smtpConfiguration.ApiKey);

            var from = new EmailAddress(_smtpConfiguration.Mail);

            var to = new EmailAddress(mailTo);

            var plainTextContent = Regex.Replace(ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLVerification)).ToString().Replace("@fullname@", fullname), "<[^>]*>", "");

            var msg = MailHelper.CreateSingleEmail(from, to, _smtpConfiguration.SubjectVerification, plainTextContent, ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLVerification)).ToString().Replace("@fullname@", fullname));

            var response = await sendGridClient.SendEmailAsync(msg);

            if (response.StatusCode != HttpStatusCode.Accepted)
            {
                throw new Exception(response.StatusCode.ToString() + ": " + response.Body);
            }
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
