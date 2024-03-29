using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Newtonsoft.Json.Linq;
using TCM.CrossCutting.Helpers;
using TCM.CrossCutting.Model;

namespace TCM.Email.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class SendMailController : ControllerBase
    {
        private readonly SendMail _sendMail;
        private readonly SMTPConfiguration _smtpConfiguration;

        public SendMailController(SendMail sendMail, SMTPConfiguration smtpConfiguration)
        {
            _sendMail = sendMail;
            _smtpConfiguration = smtpConfiguration;
        }

        [HttpGet]
        [Route("SendCodeMail")]
        public async Task<IActionResult> SendCodeMail(string mailTo, string code)
        {
            await _sendMail.SendCodeAsync(mailTo, code);

            return Ok(true);
        }

        [HttpGet]
        [Route("SendRememberPasswordMail")]
        public async Task<IActionResult> SendRememberPasswordMail(string mailTo, string token, string username)
        {
            await _sendMail.SendRememberPasswordAsync(mailTo, token, username);

            return Ok(true);
        }

        [HttpGet]
        [Route("SendWelcome")]
        public async Task<IActionResult> SendWelcome(string mailTo, string fullname)
        {
            await _sendMail.SendWelcomeAsync(mailTo, fullname);

            return Ok(true);
        }
    }
}
