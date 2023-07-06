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

            string user = value.Substring(userStartIndex, userEndIndex - userStartIndex);
            string code = value.Substring(codeStartIndex);

            return new Parameter()
            {
                Code = code,
                User = user
            };
        }
    }
}
