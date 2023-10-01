CREATE PROCEDURE [dbo].[PR_User_Insert]
	@Username					VARCHAR(100)
,	@Mobile						BIGINT
,	@Password					VARCHAR(20)
,	@Email						VARCHAR(100)
,	@Fullname					VARCHAR(200)	
AS
INSERT INTO [User]
(
	Email
,	FullName
,	MobilePhone
,	Password
,	ProfileId
,	UserName
)
VALUES
(
	@Email
,	@Fullname
,	@Mobile
,	@Password
,	2
,	@Username
)
