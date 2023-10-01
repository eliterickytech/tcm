using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Services.Services
{
    public class CollectionItemServices : ICollectionItemServices
    {
        private readonly ICollectionItemRepository _collectionItemRepository;

        public CollectionItemServices(ICollectionItemRepository collectionItemRepository)
        {
            _collectionItemRepository = collectionItemRepository;
        }

        public async Task<int> AddCollectionItemAsync(CollectionItemModel model) => await _collectionItemRepository.AddCollectionItemAsync(model);

        public async Task<IEnumerable<CollectionItemModel>> GetCollectionItemAsync(int collectionId) => await _collectionItemRepository.GetCollectionItemAsync(collectionId);

        public async Task<CollectionItemModel> GetCollectionItemDetailsAsync(int id) => await _collectionItemRepository.GetCollectionItemDetailsAsync(id);

    }
}
