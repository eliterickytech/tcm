CREATE PROCEDURE [dbo].[PR_CollectionitemShared_Select]
	@UserId									INT = NULL
,	@ConnectionUserId						INT = NULL
,	@CollectionItemId						INT = NULL
AS
SELECT
	CollectionItemShared.Id					
,	CollectionItemShared.CollectionItemId
,	CollectionItemShared.ConnectionUserId
,	CollectionItemShared.UserId
FROM
	CollectionItemShared

		INNER JOIN
		CollectionItem
		ON CollectionItem.Id = CollectionItemShared.CollectionItemId

			INNER JOIN
			Collection
			ON CollectionItem.Id = CollectionItem.CollectionId

WHERE	
	Collection.Enabled		= 1
AND CollectionItem.Enabled	= 1
AND ((@UserId IS NOT NULL AND CollectionItemShared.UserId = @UserId ) OR (@UserId IS NULL))
AND ((@ConnectionUserId IS NOT NULL AND CollectionItemShared.ConnectionUserId = @ConnectionUserId ) OR (@ConnectionUserId IS NULL))
AND ((@CollectionItemId IS NOT NULL AND CollectionItemShared.CollectionItemId = @CollectionItemId ) OR (@CollectionItemId IS NULL))

