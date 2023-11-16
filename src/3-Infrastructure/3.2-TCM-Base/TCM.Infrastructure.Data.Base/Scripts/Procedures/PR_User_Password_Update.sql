CREATE PROCEDURE [dbo].[PR_User_Password_Update]
	@Id					INT
,	@Password			VARCHAR(25)
AS

	UPDATE [User]
	SET [Password] = @Password
	WHERE Id = @Id