CREATE PROCEDURE [dbo].[PR_Chat_Update_IsReaded]
	@UserId					INT,
	@ConnectionUserId		INT 
AS

UPDATE 
	Chat
SET
	isReaded = 1,
	ChangedDate = GETDATE()

WHERE
	UserId = @UserId
	And ConnectionUserId = @ConnectionUserId