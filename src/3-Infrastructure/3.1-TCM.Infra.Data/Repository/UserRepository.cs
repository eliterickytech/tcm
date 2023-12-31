﻿using Dapper;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.Options;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Model;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Infra.Repository;

namespace TCM.Infra.Repository
{
    public class UserRepository : BaseRepository, IUserRepository
    {

        public UserRepository(IConfiguration configuration) : base(configuration) 
        { 
        
        }

        public async Task<UserModel> GetLoginAsync(string user, string password)
        {
            var query = @"PR_Login_Select";

            var parameters = new DynamicParameters();
            parameters.Add("Username", user, System.Data.DbType.String);
            parameters.Add("Password", password, System.Data.DbType.String);
            try
            {
                var result = await QueryFirstOrDefaultAsync<UserModel>(query, parameters);  
                return result;

            }
            catch (Exception ex)
            {
                return default;
            }

        }

        public async Task<IEnumerable <UserModel>> GetUserAsync(UserModel user)
        {
            var query = @"PR_User_Select";
            var parameters = new DynamicParameters();

            parameters.Add("@UserName", user.UserName, System.Data.DbType.String);
            parameters.Add("@FullName", user.FullName, System.Data.DbType.String);
            parameters.Add("@Email", user.Email, System.Data.DbType.String);
            parameters.Add("@Password", user.Password, System.Data.DbType.String);
            parameters.Add("@ProfileId", user.ProfileId == null ? null : ((int) user.ProfileId), System.Data.DbType.Int32);
            parameters.Add("@Id", user.Id, System.Data.DbType.Int32);

            return await QueryAsync<UserModel>(query, parameters);
        }

        public async Task<IEnumerable<UserModel>> GetAllUserAsync(UserModel user)
        {
            var query = @"PR_User_Select";
            var parameters = new DynamicParameters();

            parameters.Add("@UserName", user.UserName, System.Data.DbType.String);
            parameters.Add("@FullName", user.FullName, System.Data.DbType.String);
            parameters.Add("@Email", user.Email, System.Data.DbType.String);
            parameters.Add("@Password", user.Password, System.Data.DbType.String);
            parameters.Add("@ProfileId", user.ProfileId == null ? null : ((int)user.ProfileId), System.Data.DbType.Int32);
            parameters.Add("@Id", user.Id, System.Data.DbType.Int32);

            return await QueryAsync<UserModel>(query, parameters);
        }

        public async Task<IEnumerable<UserModel>> ListUserAsync()
        {
            var query = @"PR_User_Select";

            return await QueryAsync<UserModel>(query);
        }

        public async Task<int> AddUserAsync(UserModel userModel)
        {
            var query = @"PR_User_Insert";

            var parameters = new DynamicParameters();
            parameters.Add("@Email", userModel.Email, System.Data.DbType.String);
            parameters.Add("@Username", userModel.UserName, System.Data.DbType.String);
            parameters.Add("@Password", userModel.Password, System.Data.DbType.String);
            parameters.Add("@Mobile", userModel.MobilePhone, System.Data.DbType.Int64);
            parameters.Add("@Fullname", userModel.FullName, System.Data.DbType.String);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch(Exception ex) { return default; }
        }

        public async Task<int> ChangeUserAsync(UserModel userModel)
        {
            var query = @"PR_User_Update";

            var parameters = new DynamicParameters();
            parameters.Add("@Id", userModel.Id, System.Data.DbType.Int32);
            parameters.Add("@Email", userModel.Email, System.Data.DbType.String);
            parameters.Add("@Password", userModel.Password, System.Data.DbType.String);
            parameters.Add("@Mobile", userModel.MobilePhone, System.Data.DbType.Int64);
            parameters.Add("@Fullname", userModel.FullName, System.Data.DbType.String);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<int> ChangeUserPasswordAsync(int userId, string password)
        {
            var query = @"PR_User_Password_Update";

            var parameters = new DynamicParameters();
            parameters.Add("@Id", userId, System.Data.DbType.Int32);       
            parameters.Add("@Password", password, System.Data.DbType.String);
          
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<int> DeleteAdmAsync(int userId)
        {
            var query = @"PR_User_Adm_Delete";

            var parameters = new DynamicParameters();
            parameters.Add("@Id", userId, System.Data.DbType.Int32);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }        
        public async Task<int> AddAdmAsync(int userId)
        {
            var query = @"PR_User_Adm_Insert";

            var parameters = new DynamicParameters();
            parameters.Add("@Id", userId, System.Data.DbType.Int32);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<DateTime> GetLastAccessDateAsync(int userId)
        {
            var query = @"PR_User_LastAccess_Select";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", userId, System.Data.DbType.Int32);
            try
            {
                var result = await QueryFirstOrDefaultAsync<DateTime>(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<int> UpdateLastAccessDateAsync(int userId)
        {
            var query = @"PR_LastAccess_Update";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", userId, System.Data.DbType.Int32);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<int> UpdateUserEnabledAsync(int userId, int enabled)
        {
            var query = @"PR_User_Enabled_Update";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", userId, System.Data.DbType.Int32);
            parameters.Add("@Enabled", enabled, System.Data.DbType.Int32);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<IEnumerable<UserModel>> GetAllUsersAsync(UserModel user)
        {
            var query = @"PR_User_Select";
            var parameters = new DynamicParameters();

            parameters.Add("@UserName", user.UserName, System.Data.DbType.String);
            parameters.Add("@FullName", user.FullName, System.Data.DbType.String);
            parameters.Add("@Email", user.Email, System.Data.DbType.String);
            parameters.Add("@Password", user.Password, System.Data.DbType.String);
            parameters.Add("@ProfileId", user.ProfileId == null ? null : ((int)user.ProfileId), System.Data.DbType.Int32);
            parameters.Add("@Id", user.Id, System.Data.DbType.Int32);

            return await QueryAsync<UserModel>(query, parameters);
        }
    }
}
