CREATE PROCEDURE [dbo].[PR_ChatScheduled_Insert]
	@UserId					INT
,	@ConnectionUserId		INT
,	@Message				VARCHAR(1000)
,	@CreatedDate			DAteTime
AS
INSERT INTO Chat
(
	UserId
,	ConnectionUserId
,	Message
,	CreatedDate
)
VALUES
(
	@UserId
,	@ConnectionUserId
,	@Message
,	@CreatedDate
)
GO


