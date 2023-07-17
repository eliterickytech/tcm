using Dapper;
using Microsoft.Extensions.Configuration;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Model;
using System;
using System.Collections.Generic;
using System.Formats.Asn1;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TCM.Infra.Repository
{
    public class CodeRepository : BaseRepository, ICodeRepository
    {
        public CodeRepository(IConfiguration configuration) : base(configuration)
        {

        } 

        public async Task<int> SaveCodeAsync(string user, string code)
        {
            var query = @"PR_Code_Insert";

            var parameters = new DynamicParameters();
            parameters.Add("@User", user, System.Data.DbType.String);
            parameters.Add("@Code", code, System.Data.DbType.String);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<CodeModel> GetCodeByUserAsync(string user)
        {
            var query = @"PR_Code_Select";

            var parameters = new DynamicParameters();
            parameters.Add("@User", user, System.Data.DbType.String);
            return await QueryFirstOrDefaultAsync<CodeModel>(query, parameters);
        }
    }
}
