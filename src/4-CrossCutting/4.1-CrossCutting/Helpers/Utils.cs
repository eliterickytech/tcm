using Microsoft.Extensions.Configuration;
using Microsoft.IdentityModel.Tokens;
using System;
using System.Collections.Generic;
using System.IdentityModel.Tokens.Jwt;
using System.IO;
using System.Security.Claims;
using System.Text;
using TCM.Services.Model;
using Microsoft.AspNetCore.Hosting;
using SixLabors.ImageSharp;
using SixLabors.ImageSharp.Processing;

namespace TCM.CrossCutting.Helpers
{
    public class Utils
    {
        private readonly IConfiguration _configuration;
        private readonly IWebHostEnvironment _webHostEnvironment;
        public Utils(IConfiguration configuration, IWebHostEnvironment webHostEnvironment)
        {
            _configuration = configuration;
            _webHostEnvironment = webHostEnvironment;
        }

        public string GenerateToken(UserModel user)
        {
            var tokenHandler = new JwtSecurityTokenHandler();
            var key = Encoding.ASCII.GetBytes(GetToken());
            var tokenDescriptor = new SecurityTokenDescriptor
            {
                Subject = new ClaimsIdentity(new Claim[]
                {
                    new Claim(ClaimTypes.Name, user.UserName.ToString()),
                    new Claim(ClaimTypes.Email, user.Email.ToString()),
                    new Claim(ClaimTypes.Role, user.Profile.ToString()),
                    new Claim(ClaimTypes.NameIdentifier, user.Id.ToString()),
                }),
                Expires = DateTime.UtcNow.AddHours(2),
                SigningCredentials = new SigningCredentials(new SymmetricSecurityKey(key), SecurityAlgorithms.HmacSha256Signature)
            };
            var token = tokenHandler.CreateToken(tokenDescriptor);
            return tokenHandler.WriteToken(token);
        }
        public string GetToken()
        {
            return _configuration.GetSection("Secret:Authentication").Value;
        }

        public void CreateStructureFolder(string path, bool isDelete)
        {
            if (isDelete)
            {
                if (Directory.Exists(path))
                {
                    Directory.Delete(path, true);
                }
            }
            else
            {
                Directory.CreateDirectory(path);
            }
        }



    public void ResizeImage(string sourceImagePath, string destinationImagePath, int width, int height)
    {
        using (var sourceImage = Image.Load(sourceImagePath))
        {
            sourceImage.Mutate(x => x.Resize(width, height));
            sourceImage.Save(destinationImagePath);
        }
    }




    public List<string> SplitImage(string originFilePath, string destinationFolderPath, string relativeFolder, int partsCount)
    {
        List<string> result = new List<string>();

        using (Image imageOriginal = Image.Load(originFilePath))
        {
            int partWidth = imageOriginal.Width / partsCount;
            int partHeight = imageOriginal.Height / partsCount;

            int order = 1;

            for (int i = 0; i < partsCount; i++)
            {
                for (int j = 0; j < partsCount; j++)
                {
                    var clone = imageOriginal.Clone(img => img.Crop(new Rectangle(j * partWidth, i * partHeight, partWidth, partHeight)));

                    string fileName = Path.Combine(destinationFolderPath, $"{order.ToString().PadLeft(2, '0')}.png");
                    clone.Save(fileName);
                    string fileRelativePath = Path.Combine(relativeFolder, $"{order.ToString().PadLeft(2, '0')}.png");
                    result.Add(fileRelativePath);

                    order += 1;
                }
            }
        }

        return result;
    }


    public List<int> Randomize(List<int> ints)
        {
            Random random = new Random();

            List<int> list = new List<int>();

            while (ints.Count > 0)
            {
                int index = random.Next(0, ints.Count);
                list.Add(ints[index]);
                ints.RemoveAt(index);
            }

            return list;
        }
    }
}
