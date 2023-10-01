CREATE PROCEDURE [PR_Collection_Insert]
	@Name					VARCHAR(100)
,	@CollectionTypeId		INT
,	@IsPhysicalAward		BIT
,	@AvailableDate			DATETIME = NULL
	
AS
INSERT INTO Collection
(
	Name
,	ColletionTypeId
,	IsPhysicalAward
,	AvailableDate
)
VALUES
(
	@Name
,	@CollectionTypeId
,	@IsPhysicalAward
,	@AvailableDate
)
SELECT @@IDENTITY AS ID