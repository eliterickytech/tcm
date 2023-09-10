using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;


namespace TCM.Services.Services
{
    public  class CollectionServices : ICollectionServices
    {
        private readonly ICollectionRepository _collectionRepository;
        private readonly ICollectionItemUserServices _collectionItemUserServices;

        public CollectionServices(ICollectionRepository collectionRepository, ICollectionItemUserServices collectionItemUserServices)
        {
            _collectionRepository = collectionRepository;
            _collectionItemUserServices = collectionItemUserServices;
        }
        public async Task<int> AddCollectionAsync(CollectionModel model) => await _collectionRepository.AddCollectionAsync(model);
        
        public async Task<int> UpdateCollecitonAsync(CollectionModel model) => await _collectionRepository.UpdatedCollectionAsync(model);

        public async Task<IEnumerable<CollectionModel>> GetCollectionAsync() => await _collectionRepository.GetCollectionAsync();

        public async Task<int> GetCountCollectionCompletedAsync(int userId)
        {
            var collections = await GetCollectionAsync();
            
            int count = 0;
            foreach (var collection in collections)
            {
                var collectionItem = await _collectionItemUserServices.GetCollectionItemUserAsync(collection.Id, userId);

                if (collection.CollectionTypeQuantity <= collectionItem.Count())
                {
                    count++;
                }
            }
            return count;
        }

        public async Task<int> RemoveCollectionAsync(int id) => await _collectionRepository.RemoveCollectionAsync(id);
    }
}
