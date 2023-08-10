﻿using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using TCM.CrossCutting.Helpers;

using TCM.Services.Interfaces.Services;
using System.Security.Policy;
using System.Threading.Tasks;
using TCM.Services.Services;
using TCM.Services.Model;
using System.Linq;
using Microsoft.AspNetCore.Authorization;
using Microsoft.Extensions.Logging;
using System;
using TCM.CrossCutting.Models;

namespace TCM.Presentation.Controllers.Logout
{
    [AllowAnonymous]
    public class CodeController : Controller
    {
        private readonly ICodeServices _codeServices;
        private readonly SendMail _sendMail;
        private readonly IUserServices _userServices;
        private readonly Utils _utils;
        private readonly ILogger<CodeController> _logger;
        public CodeController(ICodeServices codeServices, SendMail sendMail, IUserServices userServices, Utils utils, ILogger<CodeController> logger)
        {
            _codeServices = codeServices;
            _sendMail = sendMail;
            _userServices = userServices;
            _utils = utils;
            _logger = logger;
        }

        public IActionResult Index()
        {
            return View();
        }

        public async Task< IActionResult> Mail(string token)
        {
            Parameter parameters = null;
            try
            {
                parameters = ExtractValueFromKey.Extract(token);
            }
            catch(Exception ex)
            {
                _logger.LogError($"Error extract parameters: {ex.StackTrace}");
                throw ex;
            }


            ViewBag.Token = token;

            try
            {
                await _sendMail.SendCodeAsync(parameters.User, parameters.Code);
            }
            catch(Exception ex)
            {
                _logger.LogError($"Error sendmail: {ex.StackTrace}");
                throw ex;
            }


            return View();
         }

        [HttpPost]
        public async Task<JsonResult> Validate(string token, string code)
        {
            var resultModel = new ResultModel();

            var parameters = ExtractValueFromKey.Extract(token);
            var user = await _userServices.GetUserAsync(new UserModel() { Email = parameters.User });
            var result = await _codeServices.GetCodeByUserAsync(user.FirstOrDefault().UserName);

            if (result is null) return default;
            
            if (code.ToUpper() == result.Code)
            {
                
                var userMode = await _userServices.GetUserAsync(new UserModel() { Id = result.UserId } );
                var tokenJWT = _utils.GenerateToken(userMode.FirstOrDefault());

                HttpContext.Session.SetString("Token", tokenJWT);

                resultModel.StatusCode = System.Net.HttpStatusCode.OK;
                resultModel.Data = result;
                resultModel.IsOK = true;
                resultModel.Token = tokenJWT;
                resultModel.Redirect = "/Home";
            }
            else
            {
                resultModel.StatusCode = System.Net.HttpStatusCode.InternalServerError;
                resultModel.IsOK = false;
            }

            return new JsonResult(resultModel);
        }

    }
}
