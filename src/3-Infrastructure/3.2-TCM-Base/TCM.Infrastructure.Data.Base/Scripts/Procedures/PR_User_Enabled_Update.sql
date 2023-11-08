
CREATE PROCEDURE [PR_User_Enabled_Update]
	@UserId			INT,
	@Enabled		INT 
AS

UPDATE 
	[User]
SET
	[Enabled] = @Enabled,
	ChangedDate = GETDATE()

WHERE
	Id = @UserId