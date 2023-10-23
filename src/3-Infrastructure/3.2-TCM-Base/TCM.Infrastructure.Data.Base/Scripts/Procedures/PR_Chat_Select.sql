CREATE PROCEDURE [dbo].[PR_Chat_Select]
	@UserId				INT = NULL
,	@ConnectionUserId	INT = NULL
,	@IsRead				INT = NULL
AS
SELECT
	Chat.UserId					AS ChatUserId
,	Chat.ConnectionUserId		AS ChatConnectionUserId
,	Chat.Message				AS ChatMessage
,	Chat.IsReaded				AS ChatIsRead
,	Chat.CreatedDate			AS ChatCreatedDate

,	ChatUser.UserName			AS ChatUserUserName
,	[ConnectionUser].UserName	AS ConnectionUserUserName
FROM
	Chat

		INNER JOIN
		[User] AS ChatUser
		ON ChatUser.Id = Chat.UserId


		INNER JOIN
		[User] AS ConnectionUser
		ON ConnectionUser.Id = Chat.ConnectionUserId

WHERE
	Chat.Enabled					= 1
AND ChatUser.Enabled				= 1
AND ConnectionUser.Enabled			= 1
And Chat.CreatedDate <= Getdate()
AND ((@UserId IS NOT NULL AND Chat.UserId = @UserId) OR (@UserId IS NULL))
AND ((@ConnectionUserId IS NOT NULL AND Chat.ConnectionUserId = @ConnectionUserId) OR (@ConnectionUserId IS NULL))
AND ((@IsRead IS NOT NULL AND Chat.IsReaded = @IsRead) OR (@IsRead IS NULL))


ORDER BY
	Chat.Id
	