CREATE PROCEDURE [PR_Collection_Update]
	@CollectionId			INT
,	@Name					VARCHAR(100)
,	@CollectionTypeId		INT
,	@IsPhysicalAward		BIT
,	@AvailableDate			DATETIME = NULL
	
AS
UPDATE Collection
SET Name = @Name
,	ColletionTypeId = @CollectionTypeId
,	AvailableDate = @AvailableDate
,	ChangedDate = GETDATE()
,	IsPhysicalAward = @IsPhysicalAward
WHERE 
	Id = @CollectionId