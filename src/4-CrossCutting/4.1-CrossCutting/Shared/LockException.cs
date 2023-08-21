using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.CrossCutting.Shared
{
    public class LockException : Exception
    {
        public LockException(string message) : base(message)
        {
        }
    }
}
