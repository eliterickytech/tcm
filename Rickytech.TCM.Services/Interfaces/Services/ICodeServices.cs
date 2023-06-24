using Rickytech.TCM.Services.Model;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Rickytech.TCM.Services.Interfaces.Services
{
    public interface ICodeServices
    {
        Task<CodeModel> GetCodeByUserAsync(string user);
        Task<int> SaveCodeAsync(string user, string code);
    }
}
