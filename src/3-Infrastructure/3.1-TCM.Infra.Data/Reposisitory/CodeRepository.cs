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
            var query = @"
                DECLARE @UserId INT
                SELECT @UserId = Id FROM Users WHERE Email = @User AND Enabled = 1

                INSERT INTO MFACode
                    (UserId, Code)
                VALUES
                    (@Userid, @Code)
            ";

            var parameters = new DynamicParameters();
            parameters.Add("@User", user, System.Data.DbType.String);
            parameters.Add("@Code", code, System.Data.DbType.String);
            return await ExecuteAsync(query, parameters); 
        }

        public async Task<CodeModel> GetCodeByUserAsync(string user)
        {
            var query = @"
                DECLARE @UserId INT
                SELECT @UserId = Id FROM Users WHERE Email = @User AND Enabled = 1

                SELECT TOP 1
                    Id
                ,   UserId
                ,   Code
                ,   CreatedDate
                FROM
                    MFACode
                WHERE
                    UserId  = @UserId

                ORDER BY Id DESC
            ";

            var parameters = new DynamicParameters();
            parameters.Add("@User", user, System.Data.DbType.String);
            return await QueryFirstOrDefaultAsync<CodeModel>(query, parameters);
        }
    }
}
