using Microsoft.AspNetCore.Hosting.Server;
using Microsoft.AspNetCore.Mvc;
using System.IO;
using System;
using Microsoft.AspNetCore.Http;
using SixLabors.ImageSharp;
using SixLabors.ImageSharp.Processing;

namespace TCM.Presentation.Site.Controllers
{
    public class CroppieController : Controller
    {
        public IActionResult Index()
        {
            return View();
        }

        [HttpPost]
        public IActionResult Index(IFormFile imagem)
        {
            if (imagem == null || imagem.Length == 0)
            {
                ViewBag.ErrorMessage = "Por favor, selecione uma imagem.";
                return View();
            }

            // Diretório onde as imagens cortadas serão salvas
            string saveDirectory = Path.Combine(Directory.GetCurrentDirectory(), "./wwwroot/Images");
            //Directory.CreateDirectory(saveDirectory);

            using (Image image = Image.Load(imagem.OpenReadStream()))
            {
                // Verifica se a imagem possui o tamanho correto (ou redimensione, se necessário)
                int desiredWidth = 300; // Altere o tamanho desejado para as partes cortadas, se necessário
                int desiredHeight = 300;

                if (image.Width != desiredWidth || image.Height != desiredHeight)
                {
                    image.Mutate(x => x.Resize(desiredWidth, desiredHeight));
                }

                // Corte e salve as 9 partes
                int offsetX, offsetY;
                for (int i = 0; i < 3; i++)
                {
                    offsetY = i * desiredHeight;
                    for (int j = 0; j < 3; j++)
                    {
                        offsetX = j * desiredWidth;

                        using (Image croppedImage = image.Clone(x => x.Crop(new Rectangle(offsetX, offsetY, desiredWidth, desiredHeight))))
                        {
                            string fileName = $"parte_{i + 1}_{j + 1}.png";
                            string filePath = Path.Combine(saveDirectory, fileName);

                            using (FileStream output = new FileStream(filePath, FileMode.Create))
                            {
                                croppedImage.SaveAsPng(output);
                            }
                        }
                    }
                }
            }

            ViewBag.SuccessMessage = "Imagem cortada e salva com sucesso!";
            return View();
        }
    }
}















