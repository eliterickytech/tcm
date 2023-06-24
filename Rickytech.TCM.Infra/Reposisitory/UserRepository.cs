using Dapper;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.Options;
using Rickytech.TCM.Services.Interfaces.Repository;
using Rickytech.TCM.Services.Model;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Rickytech.TCM.Infra.Reposisitory
{
    public class UserRepository : BaseRepository, IUserRepository
    {

        public UserRepository(IConfiguration configuration) : base(configuration) 
        { 
        
        }

        public async Task<UserModel> GetUserAsync(string user, string password)
        {
            var query = @"
                SELECT 
                    Id
                ,   UserName
                ,   Email
                ,   MobilePhone
                ,   Enabled
                ,   CreatedDate
                ,   ChangedDate
                ,   ProfileId
                FROM
                    Users
                WHERE
                    Enabled  = 1
                AND    
                    UserName = @UserName
                AND
                    Password = @Password
            ";

            var parameters = new DynamicParameters();
            parameters.Add("@UserName", user, System.Data.DbType.String);
            parameters.Add("Password", password, System.Data.DbType.String);

            return await 
                QueryFirstOrDefaultAsync<UserModel>(query, parameters);
        }
    }
}
