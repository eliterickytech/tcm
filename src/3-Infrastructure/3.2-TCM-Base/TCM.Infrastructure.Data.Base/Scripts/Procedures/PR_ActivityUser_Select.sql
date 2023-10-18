CREATE  PROCEDURE [dbo].[PR_ActivityUser_Select]
	@UserId					INT
AS

SELECT Distinct
	[Users].Id					As UserId,
	[Users].UserName			As UserName,
	[Users].ProfileId			As ProfileId,
	ActivityUser.ActionDescription	As ActionDescription,
	ActivityUser.ActionDate			As ActionDate
FROM
	[User] As [Users]
		INNER JOIN 	ActivityUser	As ActivityUser
		On [Users].Id = ActivityUser.UserId


WHERE 
	[Users].Id = @UserId

