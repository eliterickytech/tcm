using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;

namespace TCM.Services.Interfaces.Services
{
    public interface ICollectionItemUserServices
    {
        Task<IEnumerable<CollectionItemUserModel>> GetCollectionItemUserAsync(int collectionId, int id);
        Task<int> GetCountCollectionItemUserAsync(int collectionId, int userId);
    }
}
