using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;

namespace TCM.CrossCutting.Helpers
{
    public class ConnectionComparer : IEqualityComparer<ConnectionModel>
    {
        public bool Equals(ConnectionModel x, ConnectionModel y)
        {
            if (x == null || y == null)
                return false;

            return x.ConnectionUserId == y.ConnectionUserId && x.UserConnectionUsername == y.UserConnectionUsername;
        }

        public int GetHashCode(ConnectionModel obj)
        {
            return obj.ConnectionUserId.GetHashCode() ^ obj.UserConnectionUsername.GetHashCode();
        }
    }
}
