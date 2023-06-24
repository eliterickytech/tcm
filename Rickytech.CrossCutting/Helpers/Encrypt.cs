using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Rickytech.CrossCutting.Helpers
{
    public static class Encrypt
    {
        public static string EncodeBase64(this string text, Encoding encoding = null)
        {
            if (text == null) return null;

            encoding = encoding ?? Encoding.UTF8;
            var bytes = encoding.GetBytes(text);
            return Convert.ToBase64String(bytes);
        }

        public static string DecodeBase64(this string encodedText, Encoding encoding = null)
        {
            if (encodedText == null) return null;

            encoding = encoding ?? Encoding.UTF8;
            var bytes = Convert.FromBase64String(encodedText);
            return encoding.GetString(bytes);
        }
    }
}
