CREATE PROCEDURE [dbo].[PR_Connection_Insert]
	@UserId							INT 
,	@ConnectionUserId				INT 
,	@ConnectionStatusId				INT
AS
INSERT INTO Connection
(
	UserId
,	ConnectionUserId
,	ConnectionStatusId
)
VALUES
(
	@UserId
,	@ConnectionUserId
,	@ConnectionStatusId
)