CREATE PROCEDURE [dbo].[PR_User_Select]
	@Id					INT				= NULL
,	@Email				VARCHAR(100)	= NULL
,	@UserName			VARCHAR(100)	= NULL
,	@FullName			VARCHAR(100)	= NULL
AS
SELECT
	[User].Id
,	[User].FullName
,	[User].Email
,	[User].MobilePhone
,	[User].UserName
FROM
	[User]
WHERE	
	((@Id IS NOT NULL AND [User].Id = @Id) OR (@Id IS NULL))
AND ((@Email IS NOT NULL AND [User].Email = @Email) OR (@Email IS NULL))
AND ((@UserName IS NOT NULL AND [User].UserName = @UserName) OR (@UserName IS NULL))
AND ((@FullName IS NOT NULL AND [User].FullName LIKE '%' + @FullName + '%') OR (@FullName IS NULL))