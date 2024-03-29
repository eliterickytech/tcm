using Microsoft.Extensions.Configuration;
using TCM.CrossCutting.Helpers;
using TCM.CrossCutting.Model;

var builder = WebApplication.CreateBuilder(args);

// Add services to the container.
var config = new SMTPConfiguration();

builder.Configuration.Bind("SmtpConfiguration", config);

builder.Services.AddControllers();
// Learn more about configuring Swagger/OpenAPI at https://aka.ms/aspnetcore/swashbuckle
builder.Services.AddEndpointsApiExplorer();
builder.Services.AddSwaggerGen();
builder.Services.AddSingleton(config);
builder.Services.AddScoped<SendMail>();

var app = builder.Build();

// Configure the HTTP request pipeline.
if (app.Environment.IsDevelopment())
{
    app.UseSwagger();
    app.UseSwaggerUI();
}


app.UseHttpsRedirection();

app.UseAuthorization();

app.MapControllers();

app.Run();
