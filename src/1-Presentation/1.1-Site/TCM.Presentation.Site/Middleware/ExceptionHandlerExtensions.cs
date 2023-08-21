using Microsoft.AspNetCore.Builder;
using Microsoft.AspNetCore.Diagnostics;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc.Infrastructure;
using Microsoft.Extensions.DependencyInjection;
using System.Net;
using System.Text.Json;
using TCM.CrossCutting.Shared;

namespace TCM.Presentation.Site.Middleware
{
    public static class ExceptionHandlerExtensions
    {
        private const string _errorInternalServer = "The Internal Server Error.";
        private const string _errorLockedMessage = "The operation has locked.";

        public static void UseGlobalExceptionHandler(this IApplicationBuilder app)
        {
            app.UseExceptionHandler(builder =>
            {
                builder.Run(async context =>
                {
                    var exceptionHandlerFeature = context.Features.Get<IExceptionHandlerFeature>();

                    if (exceptionHandlerFeature is null) return;

                    context.Response.ContentType = "application/problem+json";
                    var problemDetailsFactory = context.RequestServices.GetRequiredService<ProblemDetailsFactory>();

                    context.Response.StatusCode = exceptionHandlerFeature.Error is LockException ? (int)HttpStatusCode.Locked : (int)HttpStatusCode.InternalServerError;

                    var problemDetails = problemDetailsFactory.CreateProblemDetails(context,
                          statusCode: context.Response.StatusCode,
                          title: context.Response.StatusCode == 423 ? _errorLockedMessage : _errorInternalServer,
                          detail: exceptionHandlerFeature.Error.Message);

                    var problemDetailsString = JsonSerializer.Serialize(problemDetails);

                    await context.Response.WriteAsync(problemDetailsString);

                });
            });
        }
    }

}
