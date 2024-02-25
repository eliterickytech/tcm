using Microsoft.AspNetCore.Mvc;
using TCM.Services.Interfaces.Services;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class CollectionItemSharedController : Controller
    {
        private readonly ICollectionItemSharedServices _collectionItemSharedServices;
        private readonly IUserServices _userServices;

        public CollectionItemSharedController(ICollectionItemSharedServices collectionItemSharedServices, IUserServices userServices)
        {
            _collectionItemSharedServices = collectionItemSharedServices;
            _userServices = userServices;
        }

        public IActionResult Index()
        {
            return View();
        }
    }
}
