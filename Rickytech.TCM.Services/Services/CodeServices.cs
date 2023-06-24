using Rickytech.TCM.Services.Interfaces.Repository;
using Rickytech.TCM.Services.Interfaces.Services;
using Rickytech.TCM.Services.Model;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Rickytech.TCM.Services.Services
{
    public class CodeServices : ICodeServices
    {
        private readonly ICodeRepository _codeRepository;

        public CodeServices(ICodeRepository codeRepository)
        {
            _codeRepository = codeRepository;
        }

        public async Task<int> SaveCodeAsync(string user, string code)
        {
            return await _codeRepository.SaveCodeAsync(user, code);
        }



        public async Task<CodeModel> GetCodeByUserAsync(string user)
        {
            return await _codeRepository.GetCodeByUserAsync(user);
        }
    }
}
