CREATE PROCEDURE [dbo].[PR_CollectionType_Select]
AS
SELECT
	CollectionType.Id
,	CollectionType.Name
FROM
	CollectionType

WHERE 
	CollectionType.Enabled = 1