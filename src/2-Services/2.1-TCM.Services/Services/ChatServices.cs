using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Services.Services
{
    public  class ChatServices : IChatServices
    {
        private readonly IChatRepository _chatRepository;

        public ChatServices(IChatRepository chatRepository)
        {
            _chatRepository = chatRepository;
        }

        public async Task<int> AddChatAsync(ChatModel model) => await _chatRepository.AddChatAsync(model);
        
        public async Task<IEnumerable<ChatModel>> GetChatAsync(ChatModel model) => await _chatRepository.GetChatAsync(model);

        public async Task<int> GetCountChatUnReadAsync(int connectionUserId)
        {
            var result = await GetChatAsync(new ChatModel() { ChatConnectionUserId = connectionUserId });
            return result.Where(x => !x.ChatIsRead).Count();
        }
    }
}
