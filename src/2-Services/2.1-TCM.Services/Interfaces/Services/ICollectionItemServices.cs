using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;

namespace TCM.Services.Interfaces.Services
{
    public interface ICollectionItemServices
    {
        Task<int> AddCollectionItemAsync(CollectionItemModel model);
        Task<IEnumerable<CollectionItemModel>> GetCollectionItemAsync(int collectionId);
        Task<CollectionItemModel> GetCollectionItemDetailsAsync(int id);
    }
}
