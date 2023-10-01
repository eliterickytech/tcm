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
        Task<IEnumerable<CollectionItemUserModel>> GetCollectionItemUserAsync(int collectionId, int userId);
        Task<int> InsertCollectionItemUserAsync(int collectionId, int collectionItemId, int userId);
    }
}
