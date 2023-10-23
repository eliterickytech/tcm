using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.CrossCutting.Models;

namespace TCM.CrossCutting.Helpers
{
    public static class ExtractValueFromKey
    {
        public static Parameter Extract(string token)
        {
            var value = Encrypt.DecodeBase64(token);
            int userStartIndex = value.IndexOf("user=") + "user=".Length;
            int userEndIndex = value.IndexOf("&", userStartIndex);

            if (userEndIndex == -1)
            {
                userEndIndex = value.Length;
            }

            int codeStartIndex = value.IndexOf("code=") + "code=".Length;
            int codeEndIndex = value.IndexOf("&", codeStartIndex);

            if (codeEndIndex == -1)
            {
                codeEndIndex = value.Length;
            }

            int firstAccessStartIndex = value.IndexOf("firstaccess=") + "firstaccess=".Length;
            int firstAccessEndIndex = value.IndexOf("&", firstAccessStartIndex);

            string user = value.Substring(userStartIndex, userEndIndex - userStartIndex);
            string code = value.Substring(codeStartIndex, codeEndIndex - codeStartIndex);
            string firstAccess = value.Substring(firstAccessStartIndex);

            return new Parameter()
            {
                Code = code,
                User = user,
                FirstAccess = firstAccess == "True" ? true : false
            };
        }
    }
}
