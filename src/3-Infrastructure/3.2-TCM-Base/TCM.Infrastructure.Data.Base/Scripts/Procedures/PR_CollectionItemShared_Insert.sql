CREATE PROCEDURE [dbo].[PR_CollectionItemShared_Insert]
	@UserId					INT
,	@ConnectionUserId		INT
,	@CollectionItemId		INT
AS
INSERT INTO CollectionItemShared
(
	UserId
,	ConnectionUserId
,	CollectionItemId
)
VALUES
(
	@UserId
,	@ConnectionUserId
,	@CollectionItemId
)