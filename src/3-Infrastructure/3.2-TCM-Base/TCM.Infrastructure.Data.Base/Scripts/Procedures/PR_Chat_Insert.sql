CREATE PROCEDURE [dbo].[PR_Chat_Insert]
	@UserId					INT
,	@ConnectionUserId		INT
,	@Message				VARCHAR(1000)
AS
INSERT INTO Chat
(
	UserId
,	ConnectionUserId
,	Message
)
VALUES
(
	@UserId
,	@ConnectionUserId
,	@Message
)