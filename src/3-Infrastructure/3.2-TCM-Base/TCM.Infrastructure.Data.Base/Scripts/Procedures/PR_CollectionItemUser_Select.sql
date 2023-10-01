CREATE PROCEDURE [dbo].[PR_CollectionItemUser_Select]
	@UserId					INT
,	@CollectionItemId		INT = NULL
,	@CollectionId			INT = NULL
AS
SELECT
	CollectionUser.Id					AS CollectionUserId
,	CollectionUser.CollectionItemId		AS CollectionItemId
,	CollectionUser.CollectionId			AS CollectionId
,	CollectionUser.UserId				AS UserId
FROM
	[User]

		INNER JOIN
		CollectionUser
		ON [User].Id = CollectionUser.UserId

WHERE 
	[User].Id = @UserId
AND	((@CollectionItemId IS NOT NULL AND CollectionUser.CollectionItemId = @CollectionItemId) OR (@CollectionItemId IS NULL))
AND	((@CollectionId IS NOT NULL AND CollectionUser.CollectionId = @CollectionId) OR (@CollectionId IS NULL))
