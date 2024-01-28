using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model
{
    public class LoginIdentityModel
    {
        public string Name { get; set; }

        public string Email { get; set; }

        public int Id { get; set; }

        public string UserName { get; set; }

        public int ProfileId { get; set; }
    }
}
