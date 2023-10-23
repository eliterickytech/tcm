using Dapper;
using Microsoft.Extensions.Configuration;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Infra.Repository;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Model;

namespace TCM.Infrastructure.Data.Repository
{
    public class ChatRepository : BaseRepository, IChatRepository
    {

        public ChatRepository(IConfiguration configuration) : base(configuration)
        {

        }

        public async Task<int> AddChatAsync(ChatModel model)
        {
            var query = @"PR_Chat_Insert";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", model.ChatUserId, System.Data.DbType.Int32);
            parameters.Add("@ConnectionUserId", model.ChatConnectionUserId, System.Data.DbType.Int32);
            parameters.Add("@Message", model.ChatMessage, System.Data.DbType.String);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }
        public async Task<int> AddChatScheduledAsync(ChatModel model)
        {
            var query = @"PR_ChatScheduled_Insert";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", model.ChatUserId, System.Data.DbType.Int32);
            parameters.Add("@ConnectionUserId", model.ChatConnectionUserId, System.Data.DbType.Int32);
            parameters.Add("@Message", model.ChatMessage, System.Data.DbType.String);
            parameters.Add("@CreatedDate", model.ChatCreatedDate, System.Data.DbType.DateTime);
            try
            {
                var result = await ExecuteAsync(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }

        public async Task<IEnumerable<ChatModel>> GetChatAsync(ChatModel model)
        {
            var query = @"PR_Chat_Select";

            var parameters = new DynamicParameters();
            parameters.Add("@UserId", model.ChatUserId, System.Data.DbType.Int32);
            parameters.Add("@ConnectionUserId", model.ChatConnectionUserId, System.Data.DbType.Int32);
            parameters.Add("@IsRead", model.ChatIsRead, System.Data.DbType.Boolean);

            try
            {
                var result = await QueryAsync<ChatModel>(query, parameters);
                return result;

            }
            catch (Exception ex) { return default; }
        }
    }
}
