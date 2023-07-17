using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;

namespace TCM.Services.Interfaces.Repository
{
    public interface ICollectionRepository
    {
        Task<int> AddCollectionAsync(CollectionModel model);
        Task<IEnumerable<CollectionModel>> GetCollectionAsync();
        Task<IEnumerable< CollectionTypeModel>> GetCollectionTypeAsync();
    }
}
