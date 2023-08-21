using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model.Enum;

namespace TCM.Services.Model
{
    public class UserModel
    {
        public int? Id { get; set; }

        public string UserName { get; set; }

        public string FullName { get; set; }

        public string Email { get; set; }

        public long MobilePhone { get; set; }

        public string Password { get; set; }

        public string ConfirmPassword { get; set; }

        public UserType ProfileId { get; set; }

        public string Profile { get; set; }

        public bool Enabled { get; set; }

        public DateTime CreatedDate { get; set; }

        public DateTime ChangedDate { get; set; }

        public string Redirect { get; set; }


    }
}
