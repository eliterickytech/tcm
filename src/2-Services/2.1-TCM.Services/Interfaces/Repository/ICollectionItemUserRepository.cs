using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;

namespace TCM.Services.Interfaces.Repository
{
    public interface ICollectionItemUserRepository
    {
        Task<IEnumerable<int>> GetCollectionItemUserAsync(int collectionId, int userId);
        Task<IEnumerable<CollectionItemUserModel>> GetCollectionItemUserByUserIdCollectionIdAsync(int collectionid, int userId);
    }
}
