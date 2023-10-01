CREATE TABLE [dbo].[BannerType]
(
    Id          INT NOT NULL PRIMARY KEY IDENTITY(1,1)
,   Type        VARCHAR(50) NOT NULL
,   Width       INT NOT NULL
,   Height      INT NOT NULL
,CreatedDate DATETIME DEFAULT(GETDATE())
)
