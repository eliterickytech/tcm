﻿using Newtonsoft.Json;

namespace TCM.Presentation.Site.Models
{
    public class CodeViewModel
    {
        public string Token { get; set; }

        public string Code { get; set; }

        public string Redirect { get; set; }
    }
}
