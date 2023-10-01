CREATE PROCEDURE [dbo].[PR_CollectionItem_Select]
	@CollectionId		INT		= NULL
,	@CollectionItemId	INT		= NULL
AS
SELECT
	CollectionItem.Id
,	CollectionItem.CollectionId
,	CollectionItem.CollectionItemTypeId
,	CollectionItemType.Name					AS CollectionItemTypeName
,	CollectionItemType.Width				AS CollectionItemTypeWidth
,	CollectionItemType.Height				AS CollectionItemTypeHeigh
,	CollectionItemType.IsCollectible		AS CollectionItemTypeIsCollectible
,	CollectionItem.Description
,	CollectionItem.Name						AS CollectionItemName
,	CollectionItem.Sort
,	CollectionItem.Url
,	CollectionItem.CreatedDate
FROM
	CollectionItem
	
		INNER JOIN
		CollectionItemType
		ON CollectionItemType.Id = CollectionItem.CollectionItemTypeId 

WHERE
	CollectionItem.Enabled = 1
AND ((@CollectionId IS NOT NULL AND CollectionItem.CollectionId = @CollectionId) OR (@CollectionId IS NULL))
AND ((@CollectionItemId IS NOT NULL AND CollectionItem.Id = @CollectionItemId) OR (@CollectionItemId IS NULL))

ORDER BY CollectionItem.Sort