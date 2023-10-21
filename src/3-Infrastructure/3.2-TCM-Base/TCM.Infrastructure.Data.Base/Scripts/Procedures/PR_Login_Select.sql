CREATE PROCEDURE [dbo].[PR_Login_Select]
	@Username                      VARCHAR(100),
	@Password                   VARCHAR(100)
AS
SELECT 
    Id
,   UserName
,   Email
,   MobilePhone
,   Enabled
,   CreatedDate
,   ChangedDate
,   ProfileId
,   LastAccessDate
FROM
    [User]
WHERE
    Enabled  = 1
AND    
    UserName = @Username
AND
    Password = @Password
