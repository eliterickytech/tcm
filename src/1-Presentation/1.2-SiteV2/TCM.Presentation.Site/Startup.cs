using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Builder;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Identity.UI;
using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.HttpsPolicy;
using Microsoft.EntityFrameworkCore;
using TCM.Presentation.Site.Data;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.DependencyInjection;
using Microsoft.Extensions.Hosting;
using Microsoft.AspNetCore.Authentication.JwtBearer;
using Microsoft.IdentityModel.Tokens;
using Serilog;
using System.Text;
using TCM.CrossCutting.Helpers;
using TCM.CrossCutting.Model;
using TCM.CrossCutting.Shared;
using TCM.Services.Interfaces.Repository;
using TCM.Services.Interfaces.Services;
using TCM.Services.Services;
using TCM.Infra.Repository;
using TCM.Infrastructure.Data.Repository;
using Microsoft.AspNetCore.Http;
using Microsoft.Extensions.FileProviders;
using System.IO;

namespace TCM.Presentation.Site
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
            services.AddHttpContextAccessor();

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
            services.AddScoped<ICollectionItemSharedServices, CollectionItemSharedServices>();
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
            .AddCookie(options =>
            {
                options.LoginPath = "/Login";
                options.ExpireTimeSpan = TimeSpan.FromHours(1);
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
            services.AddSession(options =>
            {
                options.IdleTimeout = TimeSpan.FromHours(1);
                options.Cookie.IsEssential = true;
            });

            services.AddLogging(loggingBuilder =>
            {
                loggingBuilder.AddSerilog();
            });
            services.AddMvc(options => options.EnableEndpointRouting = false);  
            services.AddControllersWithViews();
            services.AddRazorPages();



        }

        // This method gets called by the runtime. Use this method to configure the HTTP request pipeline.
        public void Configure(IApplicationBuilder app, IWebHostEnvironment env)
        {
            if (env.IsDevelopment())
            {
                app.UseDeveloperExceptionPage();
                app.UseMigrationsEndPoint();
            }
            else
            {
                app.UseExceptionHandler("/Home/Error");
                // The default HSTS value is 30 days. You may want to change this for production scenarios, see https://aka.ms/aspnetcore-hsts.
                app.UseHsts();
            }
            app.UseHttpsRedirection();
            app.UseStaticFiles();

            app.UseStaticFiles(new StaticFileOptions
            {
                FileProvider = new PhysicalFileProvider(
                Path.Combine(Directory.GetCurrentDirectory(), "StaticFiles")),
                RequestPath = "/StaticFiles"
            });

            app.UseStatusCodePagesWithReExecute("/Error/{0}");

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
            		endpoints.MapAreaControllerRoute(  
										name: "Identity",  
										areaName: "Identity",  
										pattern: "Identity/{controller=Home}/{action=Index}");  
                endpoints.MapControllerRoute(
                    name: "default",
                    pattern: "{controller=login}/{action=index}");
                endpoints.MapRazorPages();
            });
        }
    }
}
