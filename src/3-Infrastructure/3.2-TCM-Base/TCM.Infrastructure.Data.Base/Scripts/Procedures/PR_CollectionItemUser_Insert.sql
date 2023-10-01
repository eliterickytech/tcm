CREATE PROCEDURE [PR_CollectionItemUser_Insert]
	@CollectionId					INT
,	@CollectionItemId				INT
,	@UsersId						INT
AS
	INSERT INTO CollectionUser
	(
		CollectionId
	,	CollectionItemId
	,	UserId
	)
	VALUES
	(
		@CollectionId
	,	@CollectionItemId
	,	@UsersId
	)
RETURN @@IDENTITY
