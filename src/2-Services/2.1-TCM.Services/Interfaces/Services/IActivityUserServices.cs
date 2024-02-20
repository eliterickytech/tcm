using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;

namespace TCM.Services.Interfaces.Services
{
    public interface IActivityUserServices
    {
        Task<IEnumerable<ActivityUserModel>> GetActivityUserAsync(int userId);
        Task<IEnumerable<ActivityUserModel>> GetActivityFriendUserAsync(int userId);
        Task<int> InsertActivityUserAsync(int userId, string description);
        Task<int> InsertActivityUserIterationAsync(int userId, int activityUserId, int typeId);
        Task<int> DeleteActivityUserInterationAsync(int userId, int activityUserId, int typeId);
        Task<int> CountActivityUserIterationAsync(int activityUserId);
    }
}
