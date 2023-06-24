#See https://aka.ms/customizecontainer to learn how to customize your debug container and how Visual Studio uses this Dockerfile to build your images for faster debugging.

FROM mcr.microsoft.com/dotnet/aspnet:5.0 AS base
WORKDIR /app
EXPOSE 80
EXPOSE 443

FROM mcr.microsoft.com/dotnet/sdk:5.0 AS build
WORKDIR /src
COPY ["Rickytech.TCM.Presentation/Rickytech.TCM.Presentation.csproj", "Rickytech.TCM.Presentation/"]
RUN dotnet restore "Rickytech.TCM.Presentation/Rickytech.TCM.Presentation.csproj"
COPY . .
WORKDIR "/src/Rickytech.TCM.Presentation"
RUN dotnet build "Rickytech.TCM.Presentation.csproj" -c Release -o /app/build

FROM build AS publish
RUN dotnet publish "Rickytech.TCM.Presentation.csproj" -c Release -o /app/publish /p:UseAppHost=false

FROM base AS final
WORKDIR /app
COPY --from=publish /app/publish .
ENTRYPOINT ["dotnet", "Rickytech.TCM.Presentation.dll"]