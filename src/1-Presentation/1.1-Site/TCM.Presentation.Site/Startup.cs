using Microsoft.AspNetCore.Builder;
using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.HttpsPolicy;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.DependencyInjection;
using TCM.Services.Interfaces.Services;
using TCM.Services.Services;
using TCM.Services.Interfaces.Repository;
using TCM.CrossCutting.Model;
using TCM.Infra.Repository;
using TCM.CrossCutting.Helpers;

using TCM.Infrastructure.Data.Repository;
using Microsoft.AspNetCore.Authentication.JwtBearer;
using Microsoft.IdentityModel.Tokens;
using static Dapper.SqlMapper;
using System.Text;
using Microsoft.AspNetCore.Http;

using TCM.Presentation.Site.Middleware;
using TCM.CrossCutting.Shared;
using Microsoft.Extensions.Logging;
using Serilog.Events;
using Serilog;

namespace TCM.Presentation
{
    public class Startup
    {
        public Startup(IConfiguration configuration)
        {
            Configuration = configuration;
        }

        public IConfiguration Configuration { get; }

        // This method gets called by the runtime. Use this method to add services to the container.
        public void ConfigureServices(IServiceCollection services)
        {
            var config = new SMTPConfiguration();

            Configuration.Bind("SmtpConfiguration", config);

            var key = Encoding.ASCII.GetBytes(Configuration.GetSection("Secret:Authentication").Value);
            services.AddSession();

            services.AddScoped<ICodeServices, CodeServices>();
            services.AddScoped<IUserServices, UserServices>();
            services.AddScoped<IBannerServices, BannerServices>();  
            services.AddScoped<IConnectionServices, ConnectionServices>();
            services.AddScoped<IChatServices, ChatServices>();
            services.AddScoped<ICollectionServices, CollectionServices>();
            services.AddScoped<ICollectionItemServices, CollectionItemServices>();
            services.AddScoped<ICollectionItemUserServices, CollectionItemUserServices>();
            services.AddScoped<ISearchServices, SearchServices>();
            services.AddScoped<ICollectionItemSharedServices, CollectionItemSharedServices >();
            services.AddScoped<IActivityUserServices, ActivityUserServices>();

            services.AddScoped<ICodeRepository, CodeRepository>();
            services.AddScoped<IUserRepository, UserRepository>();
            services.AddScoped<IBannerRepository, BannerRepository>();
            services.AddScoped<IConnectionRepository, ConnectionRepository>();
            services.AddScoped<IChatRepository, ChatRepository>();
            services.AddScoped<ICollectionRepository, CollectionRepository>();
            services.AddScoped<ICollectionItemRepository, CollectionItemRepository>();
            services.AddScoped<ICollectionItemUserRepository, CollectionItemUserRepository>();
            services.AddScoped<ICollectionItemSharedRepository, CollectionItemSharedRepository>();
            services.AddScoped<IActivityUserRepository, ActivityUserRepository>();
            services.AddScoped<IBaseNotification, BaseNotification>();

            services.AddSingleton(config);
            services.AddScoped<SendMail>();
            services.AddScoped<Utils>();

            services.AddAuthentication(x =>
            {
                x.DefaultAuthenticateScheme = JwtBearerDefaults.AuthenticationScheme;
                x.DefaultChallengeScheme = JwtBearerDefaults.AuthenticationScheme;
            })

            .AddJwtBearer(x =>
                {

                    x.RequireHttpsMetadata = false;
                    x.SaveToken = true;
                    x.TokenValidationParameters = new TokenValidationParameters
                    {
                        ValidateIssuerSigningKey = true,
                        IssuerSigningKey = new SymmetricSecurityKey(key),
                        ValidateIssuer = false,
                        ValidateAudience = false
                    };
                });

            services.AddControllersWithViews();

            services.AddLogging(loggingBuilder =>
            {
                loggingBuilder.AddSerilog();
            });
        }


        public void Configure(IApplicationBuilder app, IWebHostEnvironment env)
        {
            //if (env.IsDevelopment())
            //{
            //    app.UseDeveloperExceptionPage();
            //}
            //else
            //{
            //    app.UseExceptionHandler("/Home/Error");
            //    // The default HSTS value is 30 days. You may want to change this for production scenarios, see https://aka.ms/aspnetcore-hsts.
            //    app.UseHsts();
            //}

            app.UseStatusCodePages();
            app.UseGlobalExceptionHandler();


            app.UseHttpsRedirection();
            app.UseStaticFiles();

            app.UseRouting();

            app.UseSession();

            app.Use(async (context, next) =>
            {
                var token = context.Session.GetString("Token");
                if (!string.IsNullOrEmpty(token))
                {
                    context.Request.Headers.Add("Authorization", "Bearer " + token);
                }
                await next();
            });

            app.UseAuthentication();
            app.UseAuthorization();

            app.UseCors(x => x
                .AllowAnyOrigin()
                .AllowAnyMethod()
                .AllowAnyHeader());

            app.UseEndpoints(endpoints =>
            {
                endpoints.MapControllerRoute(
                    name: "default",
                    pattern: "{controller=Login}/{action=Index}/{id?}");
            });
        }
    }
}