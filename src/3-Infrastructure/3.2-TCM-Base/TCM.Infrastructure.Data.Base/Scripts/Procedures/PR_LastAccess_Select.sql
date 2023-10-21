CREATE PROCEDURE [dbo].[PR_LastAccess_Select]
	@UserId                      INT
WITH RECOMPILE
AS
SELECT
	Id
FROM
	[User]
WHERE
	Id = @UserId
AND GETDATE() BETWEEN LastAccessDate AND DATEADD(DAY, 15, LastAccessDate)