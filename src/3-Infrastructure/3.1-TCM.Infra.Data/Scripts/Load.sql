CREATE TABLE Users
(
    Id              INT NOT NULL PRIMARY KEY IDENTITY(1,1)
,   ProfileId       INT NOT NULL
,   UserName        VARCHAR(25) NOT NULL
,   Password        VARCHAR(25) NOT NULL
,   Email           VARCHAR(100) NOT NULL
,   MobilePhone     BIGINT NOT NULL
,   Enabled         BIT NOT NULL DEFAULT(1)
,   CreatedDate     DATETIME NOT NULL DEFAULT(GETDATE())
,   ChangedDate     DATETIME null
) 

CREATE TABLE MFACode
(
    Id              INT NOT NULL PRIMARY KEY IDENTITY(1,1)
,   UserId          INT NOT NULL
,   Code            VARCHAR(10)
,   CreatedDate     DATETIME NOT NULL DEFAULT(GETDATE())
)
