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
    public  class ShareMessageServices : IShareMessageServices
    {
        private readonly IChatRepository _chatRepository;

        public ShareMessageServices(IChatRepository chatRepository)
        {
            _chatRepository = chatRepository;
        }

        public async Task<int> AddShareMessageAsync(ChatModel model) => await _chatRepository.AddChatScheduledAsync(model);
       
    }
}
