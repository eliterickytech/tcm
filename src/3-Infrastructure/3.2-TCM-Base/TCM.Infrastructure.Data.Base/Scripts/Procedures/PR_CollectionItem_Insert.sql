CREATE PROCEDURE [dbo].[PR_CollectionItem_Insert]
	@CollectionId				INT
,	@CollectionItemTypeId		INT
,	@Sort						INT
,	@Url						VARCHAR(250)
,	@Description				VARCHAR(200)
AS

INSERT INTO CollectionItem
(
	CollectionId
,	CollectionItemTypeId
,	Sort
,	Sequence
,	Url
,	Description
)
VALUES
(
	@CollectionId
,	@CollectionItemTypeId
,	@Sort
,	@Sort
,	@Url
,	@Description
)