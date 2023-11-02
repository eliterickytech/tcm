using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;

namespace TCM.Services.Interfaces.Services
{
    public interface IChatServices
    {
        Task<int> AddChatAsync(ChatModel model);
        Task<int> UpdateChatIsReadedAsync(ChatModel model);
        Task<IEnumerable<ChatModel>> GetChatAsync(ChatModel model);

        Task<int> AddChatScheduledAsync(ChatModel model);
    }
}
