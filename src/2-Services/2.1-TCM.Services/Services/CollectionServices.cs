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
        private readonly ICollectionItemSharedServices _collectionItemSharedServices;
        private readonly ICollectionItemServices _collectionItemServices;

        public CollectionServices(ICollectionRepository collectionRepository, ICollectionItemUserServices collectionItemUserServices, ICollectionItemSharedServices collectionItemSharedServices, ICollectionItemServices collectionItemServices)
        {
            _collectionRepository = collectionRepository;
            _collectionItemUserServices = collectionItemUserServices;
            _collectionItemSharedServices = collectionItemSharedServices;
            _collectionItemServices = collectionItemServices;
        }
        public async Task<int> AddCollectionAsync(CollectionModel model) => await _collectionRepository.AddCollectionAsync(model);
        
        public async Task<int> UpdateCollecitonAsync(CollectionModel model) => await _collectionRepository.UpdatedCollectionAsync(model);

        public async Task<IEnumerable<CollectionModel>> GetCollectionAsync() => await _collectionRepository.GetCollectionAsync();

        public async Task<IEnumerable<CollectionModel>> GetCollectionAdmAsync() => await _collectionRepository.GetCollectionAdmAsync();

        public async Task<CollectionModel> GetCollectionByIdAsync(int id) => await _collectionRepository.GetCollectionByIdAsync(id);
        public async Task<int> GetCountCollectionCompletedAsync(int userId)
        {
            var collections = await GetCollectionAsync();
            
            List<int> countsCollectionsCompleted = new List<int>();

            foreach (var collection in collections)
            {
                var collectionItem = await _collectionItemServices.GetCollectionItemAsync(collection.Id, null);

                collectionItem = collectionItem.Where(x => x.CollectionItemTypeIsCollectible);

                int count = 0;

                foreach (var item in collectionItem)
                {
                    var collectionItemUser = await _collectionItemSharedServices.GetCollectionItemSharedAsync(new CollectionItemSharedModel() { UserId = userId, CollectionItemId = item.Id});

                    if (collectionItemUser.Any())
                    {
                        count++;
                    }
                }

                if (collection.CollectionTypeQuantity == count)
                {
                    countsCollectionsCompleted.Add(collection.Id);
                }
            }
            return countsCollectionsCompleted.Distinct().Count();
        }

        public async Task<int> RemoveCollectionAsync(int id) => await _collectionRepository.RemoveCollectionAsync(id);
    }
}
