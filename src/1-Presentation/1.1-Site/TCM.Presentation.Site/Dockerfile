#See https://aka.ms/customizecontainer to learn how to customize your debug container and how Visual Studio uses this Dockerfile to build your images for faster debugging.

FROM mcr.microsoft.com/dotnet/aspnet:6.0 AS base
WORKDIR /app
EXPOSE 80
EXPOSE 443

FROM mcr.microsoft.com/dotnet/sdk:6.0 AS build
WORKDIR /src
COPY ["src/1-Presentation/1.1-Site/TCM.Presentation.Site/TCM.Presentation.Site.csproj", "src/1-Presentation/1.1-Site/TCM.Presentation.Site/"]
COPY ["src/2-Services/2.1-TCM.Services/TCM.Services.csproj", "src/2-Services/2.1-TCM.Services/"]
COPY ["src/3-Infrastructure/3.1-TCM.Infra.Data/TCM.Infrastructure.Data.csproj", "src/3-Infrastructure/3.1-TCM.Infra.Data/"]
COPY ["src/4-CrossCutting/4.1-CrossCutting/TCM.CrossCutting.csproj", "src/4-CrossCutting/4.1-CrossCutting/"]
RUN dotnet restore "src/1-Presentation/1.1-Site/TCM.Presentation.Site/TCM.Presentation.Site.csproj"
COPY . .
WORKDIR "/src/src/1-Presentation/1.1-Site/TCM.Presentation.Site"
RUN dotnet build "TCM.Presentation.Site.csproj" -c Release -o /app/build

FROM build AS publish
RUN dotnet publish "TCM.Presentation.Site.csproj" -c Release -o /app/publish /p:UseAppHost=false

FROM base AS final
WORKDIR /app
COPY --from=publish /app/publish .
ENTRYPOINT ["dotnet", "TCM.Presentation.Site.dll"]