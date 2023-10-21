CREATE PROCEDURE [dbo].[PR_LastAccess_Update]
	@UserId                      INT				
WITH RECOMPILE
AS
UPDATE
	[User]
SET LastAccessDate = GETDATE()
WHERE
	Id = @UserId