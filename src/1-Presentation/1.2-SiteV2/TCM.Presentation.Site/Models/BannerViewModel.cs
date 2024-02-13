using Microsoft.AspNetCore.Http;

namespace TCM.Presentation.Site.Models
{
    public class BannerViewModel
    {
        public IFormFile imageUpload { get; set; }
        public string RedirectTo { get; set; }
        public string Password { get; set; }
    }
}
