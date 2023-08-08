using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Services.Model.Enum
{
    public enum ConnectionStatusType
    {
        Requested = 1,
        Approved  = 2,
        Blocked  = 3,
        Pending = 4,
        Canceled = 5
    }
}
