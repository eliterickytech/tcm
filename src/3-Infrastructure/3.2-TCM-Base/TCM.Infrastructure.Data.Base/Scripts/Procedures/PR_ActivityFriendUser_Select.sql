CREATE  PROCEDURE [dbo].[PR_ActivityFriendsUser_Select]
	@UserId					INT
AS

SELECT Distinct
	friendUser.Id					As UserId,
	friendUser.UserName				As UserName,
	FriendUser.ProfileId			As ProfileId,
	ActivityUser.ActionDescription	As ActionDescription,
	ActivityUser.ActionDate			As ActionDate
FROM
	[User] As [Users]

		INNER JOIN	Connection		AS ConnectionUser
		ON [Users].[Id] = ConnectionUser.UserId
		And ConnectionUser.Enabled = 1

		INNER JOIN [User] As friendUser
		On ConnectionUser.ConnectionUserId = friendUser.Id
		And friendUser.Enabled = 1
		INNER JOIN 	ActivityUser	As ActivityUser
		On friendUser.Id = ActivityUser.UserId


WHERE 
	[Users].Id = @UserId

