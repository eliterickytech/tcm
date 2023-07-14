CREATE TABLE [dbo].[Banner]
(
    Id              INT NOT NULL PRIMARY KEY IDENTITY(1,1)
,   BannerTypeId    INT NOT NULL
,   Url             VARCHAR(200) NOT NULL
,   RedirectTo      VARCHAR(200) NULL
,   Video           BIT NOT NULL DEFAULT(0)    
,   Enabled         BIT NOT NULL DEFAULT(1)
,   CreatedDate     DATETIME NOT NULL DEFAULT(GETDATE())
,   ChangedDate     DATETIME NULL
)
