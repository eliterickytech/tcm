CREATE PROCEDURE [dbo].[PR_Collection_Select]
AS
SELECT
	Collection.Id
,	Collection.IsPhysicalAward
,	Collection.Enabled
,	Collection.Name					AS CollectionName
,	CollectionType.Name				AS CollectionTypeName
,	CollectionType.Quantity			AS CollectionTypeQuantity
,	CollectionType.Id				AS CollectionTypeId
,	Collection.CreatedDate			AS CollectionCreatedDate
FROM
	Collection

		INNER JOIN
		CollectionType
		ON CollectionType.Id = Collection.ColletionTypeId

WHERE
	Collection.Enabled			= 1
AND GETDATE() >= Collection.AvailableDate
AND EXISTS(SELECT CollectionId FROM CollectionItem WHERE CollectionId = Collection.Id)


