using Microsoft.Extensions.Configuration;
using Microsoft.IdentityModel.Tokens;
using System;
using System.Collections.Generic;
using System.IdentityModel.Tokens.Jwt;
using System.IO;
using System.Linq;
using System.Reflection;
using System.Security.Claims;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;
using System.Drawing;
using System.Drawing.Imaging;
using Microsoft.AspNetCore.Hosting;
using System.Drawing.Drawing2D;

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

        public List<string> SplitImage(string originFilePath, string destinationFolderPath, int partsCount)
        {
            List<string> result = new List<string>();

            using (Bitmap imageOriginal = new Bitmap(originFilePath))
            {
                int partWidth = imageOriginal.Width / partsCount;
                int partHeight = imageOriginal.Height / partsCount;

                int order = 1;

                for (int i = 0; i < partsCount; i++)
                {
                    for (int j = 0; j < partsCount; j++)
                    {
                        Rectangle partRect = new Rectangle(j * partWidth, i * partHeight, partWidth, partHeight);
                        using (Bitmap part = new Bitmap(partWidth, partHeight))
                        {
                            using (Graphics graphics = Graphics.FromImage(part))
                            {
                                graphics.DrawImage(imageOriginal, new Rectangle(0, 0, partWidth, partHeight), partRect, GraphicsUnit.Pixel);
                            }

                            string fileName = Path.Combine(destinationFolderPath, $"{order.ToString().PadLeft(2, '0')}.png");
                            part.Save(fileName, ImageFormat.Png);
                            result.Add(fileName);
                        }

                        order += 1;
                    }
                }
            }

            return result;
        }

        public void ResizeImage(string sourceImagePath, string destinationImagePath, int width, int height)
        {
            using (var sourceImage = Image.FromFile(sourceImagePath))
            {
                using (var resizedImage = new Bitmap(width, height))
                {
                    using (var graphics = Graphics.FromImage(resizedImage))
                    {
                        graphics.InterpolationMode = InterpolationMode.HighQualityBicubic;
                        graphics.DrawImage(sourceImage, 0, 0, width, height);
                    }

                    resizedImage.Save(destinationImagePath, sourceImage.RawFormat);
                }
            }
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
