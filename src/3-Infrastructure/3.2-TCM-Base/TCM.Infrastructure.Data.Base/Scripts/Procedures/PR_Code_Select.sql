CREATE PROCEDURE [dbo].[PR_Code_Select]
	@User                 VARCHAR(100)
AS
DECLARE @UserId INT
SELECT @UserId = Id FROM [User] WHERE [User].UserName = @User AND Enabled = 1

SELECT TOP 1
    Id
,   UserId
,   Code
,   CreatedDate
FROM
    MFACode
WHERE
    UserId  = @UserId

ORDER BY Id DESC