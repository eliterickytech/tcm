using Flunt.Notifications;
using System.Collections.Generic;

namespace TCM.Services.Interfaces.Services
{
    public interface IBaseNotification
    {
        IReadOnlyCollection<Notification> Notifications { get; }
        void AddNotifications(IReadOnlyCollection<Notification> notifications);
        bool IsValid { get; }
    }
}
