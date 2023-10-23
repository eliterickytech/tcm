CREATE TABLE [dbo].[User]
(
    Id              INT NOT NULL PRIMARY KEY IDENTITY(1,1)
,   ProfileId       INT NOT NULL
,   FullName        VARCHAR(100) NOT NULL
,   UserName        VARCHAR(25) NOT NULL
,   Password        VARCHAR(25) NOT NULL
,   Email           VARCHAR(100) NOT NULL
,   MobilePhone     BIGINT NOT NULL
,   Enabled         BIT NOT NULL DEFAULT(1)
,   LastAccessDate  DATETIME NULL
,   CreatedDate     DATETIME NOT NULL DEFAULT(GETDATE())
,   ChangedDate     DATETIME null
)
