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
    public class CollectionItemSharedServices : ICollectionItemSharedServices
    {
        private readonly ICollectionItemSharedRepository _collectionItemSharedRepository;

        public CollectionItemSharedServices(ICollectionItemSharedRepository collectionItemSharedRepository)
        {
            _collectionItemSharedRepository = collectionItemSharedRepository;
        }

        public async Task<IEnumerable<CollectionItemSharedModel>> GetCollectionItemSharedAsync(CollectionItemSharedModel model)
        {
            return await _collectionItemSharedRepository.GetCollectionItemSharedAsync(model);
        }

        public async Task<int> InsertCollectionItemSharedAsync(CollectionItemSharedModel model) =>
            await _collectionItemSharedRepository.InsertCollectionItemSharedAsync(model);


    }
}
