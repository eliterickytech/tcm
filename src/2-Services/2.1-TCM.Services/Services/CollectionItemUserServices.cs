using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml.XPath;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Services.Services
{
    public class CollectionItemUserServices : ICollectionItemUserServices
    {
        private readonly ICollectionItemUserRepository _collectionItemUserRepository;

        public CollectionItemUserServices(ICollectionItemUserRepository collectionItemUserRepository)
        {
            _collectionItemUserRepository = collectionItemUserRepository;
        }

        public async Task<IEnumerable<int>> GetCollectionItemUserAsync(int collectionId, int userId) => await _collectionItemUserRepository.GetCollectionItemUserAsync(collectionId, userId);

        public async Task<IEnumerable<CollectionItemUserModel>> GetCollectionItemUserByUserIdCollectionIdAsync(int collectionId, int userId) => await _collectionItemUserRepository.GetCollectionItemUserByUserIdCollectionIdAsync(collectionId, userId);

        public async Task<int> GetCountCollectionItemUserAsync(int collectionId, int userId)
        {
            var result = await _collectionItemUserRepository.GetCollectionItemUserAsync(collectionId, userId);
            return result.Count();
        }
    }
}
