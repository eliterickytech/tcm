using System;
using TCM.Presentation.Site.Areas.Identity.Data;
using Microsoft.AspNetCore.Hosting;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Identity.UI;
using Microsoft.EntityFrameworkCore;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.DependencyInjection;

[assembly: HostingStartup(typeof(TCM.Presentation.Site.Areas.Identity.IdentityHostingStartup))]
namespace TCM.Presentation.Site.Areas.Identity
{
    public class IdentityHostingStartup : IHostingStartup
    {
        public void Configure(IWebHostBuilder builder)
        {
            builder.ConfigureServices((context, services) => {
            		services.AddDbContext<TCMPresentationSiteIdentityDbContext>(options =>
										options.UseSqlite(
												context.Configuration.GetConnectionString("DefaultConnection")));
                //services.AddDbContext<TCM.Presentation.SiteIdentityDbContext>(options =>
                //    options.UseSqlServer(
                //        context.Configuration.GetConnectionString("TCM.Presentation.SiteIdentityDbContextConnection")));

                services.AddDefaultIdentity<IdentityUser>(options => options.SignIn.RequireConfirmedAccount = true)
                    .AddEntityFrameworkStores<TCMPresentationSiteIdentityDbContext>();
            });
        }
    }
}