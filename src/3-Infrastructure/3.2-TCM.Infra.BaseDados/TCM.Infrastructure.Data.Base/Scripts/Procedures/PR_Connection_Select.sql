CREATE PROCEDURE [dbo].[PR_Connection_Select]
	@Id					INT = NULL
,	@UserId				INT = NULL
,	@ConnectionUserId	INT = NULL
,	@ConnectionStatusId	INT = NULL
,	@Email				VARCHAR(100) = NULL
,	@UserName			VARCHAR(100) = NULL

AS

SELECT 
	[User].Id										AS UserId
,	[User].[FullName]								AS UserFullName
,	[User].Email									AS UserEmail
,	[User].UserName									AS UserUsername
,	[User].MobilePhone								AS UserMobilePhone

,	ConnectionUser.Id								AS ConnectionUserId
,	ConnectionUser.ConnectionStatusId				AS ConnectionUserConnectionStatusId
,	ConnectionUser.CreatedDate						AS ConnectionUserCreatedDate
,	ConnectionStatusUser.Name						AS ConnectionStatusUserName

,	UserConnection.Id								AS UserConnectionId
,	UserConnection.[FullName]						AS UserConnectionFullName
,	UserConnection.Email							AS UserConnectionEmail
,	UserConnection.UserName							AS UserConnectionUsername
,	UserConnection.MobilePhone						AS UserConnectionMobilePhone


FROM
	[User]
		
		LEFT JOIN
		Connection			AS ConnectionUser
		ON [User].[Id] = ConnectionUser.UserId
		AND [User].Enabled = 1

			LEFT JOIN 
			ConnectionStatus AS ConnectionStatusUser
			ON ConnectionStatusUser.Id = ConnectionUser.ConnectionStatusId

		LEFT JOIN
		Connection AS ConnectionConnectionUser
		ON [User].Id = ConnectionConnectionUser.ConnectionUserId
		AND [User].Enabled = 1

			LEFT JOIN 
			ConnectionStatus AS ConnectionConnectionStatus
			ON ConnectionConnectionStatus.Id = ConnectionConnectionUser.ConnectionStatusId

			LEFT JOIN
			[User] AS UserConnection
			ON UserConnection.Id = ConnectionUser.ConnectionUserId 


WHERE	
	((@Id IS NOT NULL AND ConnectionUser.Id = @Id) OR (@Id IS NULL))
AND ((@UserId IS NOT NULL AND ConnectionUser.UserId = @UserId) OR (@UserId IS NULL))
AND ((@ConnectionUserId IS NOT NULL AND ConnectionUser.ConnectionUserId = @ConnectionUserId) OR (@ConnectionUserId IS NULL))
AND ((@ConnectionStatusId IS NOT NULL AND ConnectionUser.ConnectionStatusId = @ConnectionStatusId) OR (@ConnectionStatusId IS NULL))
AND ((@Email IS NOT NULL AND [User].Email = @Email) OR (@Email IS NULL))
AND ((@UserName IS NOT NULL AND [User].UserName = @UserName) OR (@UserName IS NULL))