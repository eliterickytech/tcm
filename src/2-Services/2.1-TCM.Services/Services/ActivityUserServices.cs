using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml.XPath;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Services.Services
{
    public class ActivityUserServices : IActivityUserServices
    {
        private readonly IActivityUserService _activityUserRepository;

        public ActivityUserServices(IActivityUserService activityUserRepository)
        {
            _activityUserRepository = activityUserRepository;
        }

        public async Task<IEnumerable<ActivityUserModel>> GetActivityUserAsync(int userId) => await _activityUserRepository.GetActivityUserAsync( userId);
        public async Task<IEnumerable<ActivityUserModel>> GetActivityFriendUserAsync(int userId) => await _activityUserRepository.GetActivityFriendUserAsync( userId);
   
        public async Task<int> InsertActivityUserAsync(int userId, string description) => await _activityUserRepository.InsertActivityUserAsync(userId, description);

        public async Task<int> InsertActivityUserIterationAsync(int userId, int activityUserId, int typeId) => await _activityUserRepository.InsertActivityUserIterationAsync(userId, activityUserId, typeId);

        public async Task<int> DeleteActivityUserInterationAsync(int userId, int activityUserId, int typeId) => await _activityUserRepository.DeleteActivityUserIterationAsync(userId, activityUserId, typeId);

        public async Task<int> CountActivityUserIterationAsync(int activityUserId) => await _activityUserRepository.CountActivityUserIterationAsync(activityUserId);

    }
}
