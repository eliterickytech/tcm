using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;

namespace TCM.Services.Interfaces.Repository
{
    public interface ICollectionItemSharedRepository
    {
        Task<IEnumerable<CollectionItemSharedModel>> GetCollectionItemSharedAsync(CollectionItemSharedModel model);
        Task<int> InsertCollectionItemSharedAsync(CollectionItemSharedModel model);
    }
}
