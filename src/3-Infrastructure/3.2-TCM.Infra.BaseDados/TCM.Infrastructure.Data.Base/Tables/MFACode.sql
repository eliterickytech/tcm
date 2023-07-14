CREATE TABLE MFACode
(
    Id              INT NOT NULL PRIMARY KEY IDENTITY(1,1)
,   UserId          INT NOT NULL
,   Code            VARCHAR(10)
,   CreatedDate     DATETIME NOT NULL DEFAULT(GETDATE())
)