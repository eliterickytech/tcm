CREATE PROCEDURE [dbo].[PR_User_Update]
	@Id					INT 
,	@Email				VARCHAR(100)
,	@Password			VARCHAR(25)
,	@Mobile				BIGINT
,	@Fullname			VARCHAR(200)
AS
UPDATE [User]
SET Email = @Email
,	Password = @Password
,	MobilePhone = @Mobile
,	FullName = @Fullname
,	ChangedDate = GETDATE()
WHERE Id = @Id