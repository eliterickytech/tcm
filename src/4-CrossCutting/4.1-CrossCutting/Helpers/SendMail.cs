

using System;
using System.IO;
using System.Net;
using System.Net.Mail;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using SendGrid;
using SendGrid.Helpers.Mail;
using TCM.CrossCutting.Model;

namespace TCM.CrossCutting.Helpers
{
    public class SendMail
    {
        private readonly SMTPConfiguration _smtpConfiguration;
        public SendMail(SMTPConfiguration smtpConfiguration)
        {
            _smtpConfiguration = smtpConfiguration;
        }

        public async Task SendCodeAsync(string mailTo, string code)
        {
            var sendGridClient = new SendGridClient(_smtpConfiguration.ApiKey);

            var from = new EmailAddress(_smtpConfiguration.Mail);

            var to = new EmailAddress(mailTo);

            var plainTextContent = Regex.Replace(ReadHtmlFile(_smtpConfiguration.HTMLVerification).ToString().Replace("@AccessCode@", code), "<[^>]*>", "");

            var msg = MailHelper.CreateSingleEmail(from, to, _smtpConfiguration.SubjectVerification, plainTextContent, ReadHtmlFile(_smtpConfiguration.HTMLVerification).ToString().Replace("@AccessCode@", code));

            var response = await sendGridClient.SendEmailAsync(msg);

            if (response.StatusCode != HttpStatusCode.Accepted)
            {
                throw new Exception(response.StatusCode.ToString() + ": " + response.Body);
            }
        }

        public async Task SendWelcomeAsync(string mailTo, string fullname)
        {
            var sendGridClient = new SendGridClient(_smtpConfiguration.ApiKey);

            var from = new EmailAddress(_smtpConfiguration.Mail);

            var to = new EmailAddress(mailTo);

            var plainTextContent = Regex.Replace(ReadHtmlFile(_smtpConfiguration.HTMLVerification).ToString().Replace("@fullname@", fullname), "<[^>]*>", "");

            var msg = MailHelper.CreateSingleEmail(from, to, _smtpConfiguration.SubjectWelcome, plainTextContent, ReadHtmlFile(_smtpConfiguration.HTMLWelcome).ToString().Replace("@fullname@", fullname));

            var response = await sendGridClient.SendEmailAsync(msg);
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
