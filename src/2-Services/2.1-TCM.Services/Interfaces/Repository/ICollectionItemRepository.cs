using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;

namespace TCM.Services.Interfaces.Repository
{
    public interface ICollectionItemRepository
    {
        Task<int> AddCollectionItemAsync(CollectionItemModel model);
        Task<IEnumerable<CollectionItemModel>> GetCollectionItemAsync();
        Task<IEnumerable<CollectionItemModel>> GetCollectionItemByCollectionIdAsync(int? collectionId, int? collectionItemId);
        Task<CollectionItemModel> GetCollectionItemDetailsAsync(int id);
    }
}
