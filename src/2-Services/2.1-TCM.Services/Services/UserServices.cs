﻿
using System.Threading.Tasks;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;
using Microsoft.Extensions.Configuration;
using System.Collections;
using System.Collections.Generic;
using System;
using System.Linq;
using Microsoft.AspNetCore.Http;

namespace TCM.Services.Services
{
    public class UserServices : IUserServices
    {
        private readonly IUserRepository _userRepository;
        private readonly IConnectionRepository _connectionRepository;
        private readonly IHttpContextAccessor _httpContextAccessor;

        public UserServices(IUserRepository userRepository, IConnectionRepository connectionRepository, IHttpContextAccessor httpContextAccessor)
        {
            _userRepository = userRepository;
            _connectionRepository = connectionRepository;
            _httpContextAccessor = httpContextAccessor;
        }

        public async Task<UserModel> GetLoginAsync(string user, string password) => await _userRepository.GetLoginAsync(user, password);

        public async Task<IEnumerable<UserModel>> GetUserAsync(UserModel user) => await _userRepository.GetUserAsync(user);

        public async Task<int> AddUserAsync(UserModel userModel) 
        {
            var user = await _userRepository.GetUserAsync(new UserModel() { Email = userModel.Email });

            if (user.Any())
                return -1;

            user = await _userRepository.GetUserAsync(new UserModel() { UserName = userModel.UserName });
            if (user.Any())
                return -2;

            var userConnection = new ConnectionModel()
            {
                ConnectionUserId = 1,
                UserId = userModel.Id,
                ConnectionUserConnectionStatusId = 2

            };
            await _connectionRepository.AddConnectionAsync(userConnection);

            return await _userRepository.AddUserAsync(userModel);
        }

        public async Task<int> ChangeUserAsync(UserModel userModel) => await _userRepository.ChangeUserAsync(userModel);

        public async Task<int> ChangeUserPasswordAsync(int userId, string password) => await _userRepository.ChangeUserPasswordAsync(userId, password);

        public async Task<int> DeleteUserAsync(int id) => await _userRepository.DeleteAdmAsync(id);

        public async Task<int> AddAdmAsync(int id) => await _userRepository.AddAdmAsync(id);

        public async Task<IEnumerable<UserModel>> ListUserAsync() => await _userRepository.ListUserAsync();

        public async Task<DateTime> GetLastAccessDateAsync(int userId) => await _userRepository.GetLastAccessDateAsync(userId);

        public async Task<int> UpdateLastAccessDateAsync(int userId) => await _userRepository.UpdateLastAccessDateAsync(userId);

        public Task<int> UpdateUserEnabledAsync(int userId, int enabled) => _userRepository.UpdateUserEnabledAsync(userId, enabled);

        public Task<IEnumerable<UserModel>> GetAllUsersAsync(UserModel user) => _userRepository.GetAllUsersAsync(user);

        public LoginIdentityModel CurrentUserAsync()
        {
            return new LoginIdentityModel()
            {
                Id = Convert.ToInt32(_httpContextAccessor.HttpContext.Session.GetString("Id")),
                Email = _httpContextAccessor.HttpContext.Session.GetString("Email"),
                UserName = _httpContextAccessor.HttpContext.Session.GetString("UserName"),
                ProfileId = Convert.ToInt32(_httpContextAccessor.HttpContext.Session.GetString("ProfileId")),
                Name = _httpContextAccessor.HttpContext.Session.GetString("FullName"),                
            };
        }

    }
}
