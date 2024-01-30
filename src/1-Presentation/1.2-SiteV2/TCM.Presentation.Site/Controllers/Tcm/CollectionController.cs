using Microsoft.AspNetCore.Mvc;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using TCM.Services.Interfaces.Services;
using TCM.Services.Model;

namespace TCM.Presentation.Site.Controllers.Tcm
{
    public class CollectionController : Controller
    {
        private readonly ICollectionItemServices _collectionItemServices;

        public CollectionController(ICollectionItemServices collectionItemServices)
        {
            _collectionItemServices = collectionItemServices;
        }

        public IActionResult Index()
        {
            return View();
        }
        [HttpGet]
        public async Task<JsonResult> GetCollectionItemById(int id)
        {
            var collectionItem = (await _collectionItemServices.GetCollectionItemAsync(null, id)).FirstOrDefault();

            return new JsonResult(new ResultModel()
            {
                StatusCode = collectionItem != null ? HttpStatusCode.OK : HttpStatusCode.BadRequest,
                IsOK = collectionItem != null,
                Data = collectionItem
            });
        }
    }
}
