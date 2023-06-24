using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Rickytech.TCM.Services.Interfaces.Services;
using Rickytech.TCM.Services.Model;
using System;
using System.Threading.Tasks;

namespace Rickytech.TCM.API.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class CodeController : ControllerBase
    {
        private readonly ICodeServices _codeServices;

        public CodeController(ICodeServices codeServices)
        {
            _codeServices = codeServices;
        }

        [HttpPost]
        public async Task<ResultModel> Save([FromBody] string user)
        {
            var code = _codeServices.GeneratedCode(6);

            var result = await _codeServices.SaveCodeAsync(user, code);

            return new ResultModel()
            {
                IsOK = result > 0 ? true : false,
                StatusCode = result > 0 ? Ok().StatusCode : BadRequest().StatusCode,
                Data = code
            }; 
        }
    }
}
