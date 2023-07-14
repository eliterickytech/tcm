﻿CREATE PROCEDURE [dbo].[PR_Login_Select]
	@Email                      VARCHAR(100),
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
FROM
    [User]
WHERE
    Enabled  = 1
AND    
    Email = @Email
AND
    Password = @Password