

using System;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Mail;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
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

            string root = _webHostEnvironment.WebRootPath;

            MailMessage message = new MailMessage();

            var from = new EmailAddress(_smtpConfiguration.Mail);

            var to = new EmailAddress(mailTo);

            message.Subject = "Team Chef Melo - Remmember password";

            var plainTextContent = Regex.Replace(ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLRememberPassword)).ToString().Replace("@url@", token).Replace("@username@", username), "<[^>]*>", "");

            var msg = MailHelper.CreateSingleEmail(from, to, _smtpConfiguration.SubjectVerification, plainTextContent, ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLRememberPassword)).ToString().Replace("@username@", username));
            
            message.To.Add(mailTo);

            message.From = new MailAddress(_smtpConfiguration.Mail);

            message.Body = msg.Contents.LastOrDefault().Value.Replace("@url@", token);

            message.IsBodyHtml = true;

            SmtpClient smtpClient = new SmtpClient(_smtpConfiguration.Host, _smtpConfiguration.Port);

            try
            {
                smtpClient.UseDefaultCredentials = false;

                smtpClient.Credentials = new NetworkCredential(_smtpConfiguration.Mail, _smtpConfiguration.Password);

                smtpClient.EnableSsl = false;

                await smtpClient.SendMailAsync(message);
            }
            catch (Exception ex)
            {
                throw new Exception(ex.Message);
            }

        }

        public async Task SendCodeAsync(string mailTo, string code)
         {
            string root = _webHostEnvironment.WebRootPath;

            MailMessage message = new MailMessage();

            var from = new EmailAddress(_smtpConfiguration.Mail);

            var to = new EmailAddress(mailTo);

            message.Subject = _smtpConfiguration.SubjectVerification;

             var plainTextContent = Regex.Replace(ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLVerification)).ToString().Replace("@AccessCode@", code), "<[^>]*>", "");

            var msg = MailHelper.CreateSingleEmail(from, to, _smtpConfiguration.SubjectVerification, plainTextContent, ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLVerification)).ToString().Replace("@AccessCode@", code));

            message.To.Add(mailTo);

            message.From = new MailAddress(_smtpConfiguration.Mail);

            message.Body = msg.Contents.LastOrDefault().Value;

            message.IsBodyHtml = true;

            SmtpClient smtpClient = new SmtpClient(_smtpConfiguration.Host, _smtpConfiguration.Port);

            try
            {
                smtpClient.UseDefaultCredentials = false;

                smtpClient.Credentials = new NetworkCredential(_smtpConfiguration.Mail, _smtpConfiguration.Password);

                smtpClient.EnableSsl = false;

                await smtpClient.SendMailAsync(message);
            }
            catch (Exception ex)
            {
                throw new Exception(ex.Message);
            }

        }

        public async Task SendWelcomeAsync(string mailTo, string fullname)
        {
            string root = _webHostEnvironment.WebRootPath;

            MailMessage message = new MailMessage();

            var from = new EmailAddress(_smtpConfiguration.Mail);

            var to = new EmailAddress(mailTo);

            message.Subject = _smtpConfiguration.SubjectWelcome;

            var plainTextContent = Regex.Replace(ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLWelcome)).ToString().Replace("@fullname@", fullname), "<[^>]*>", "");

            var msg = MailHelper.CreateSingleEmail(from, to, _smtpConfiguration.SubjectWelcome, plainTextContent, ReadHtmlFile(string.Concat(root, _smtpConfiguration.HTMLWelcome)).ToString().Replace("@fullname@", fullname));

            message.To.Add(mailTo);

            message.From = new MailAddress(_smtpConfiguration.Mail);

            message.Body = msg.Contents.LastOrDefault().Value;

            message.IsBodyHtml = true;

            SmtpClient smtpClient = new SmtpClient(_smtpConfiguration.Host, _smtpConfiguration.Port);

            try
            {
                smtpClient.UseDefaultCredentials = false;

                smtpClient.Credentials = new NetworkCredential(_smtpConfiguration.Mail, _smtpConfiguration.Password);

                smtpClient.EnableSsl = false;

                await smtpClient.SendMailAsync(message);
            }
            catch (Exception ex)
            {
                throw new Exception(ex.Message);
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
