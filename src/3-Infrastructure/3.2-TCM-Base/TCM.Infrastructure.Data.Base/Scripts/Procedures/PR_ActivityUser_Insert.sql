CREATE PROCEDURE [dbo].[PR_ActivityFiendsUser_Insert]
	@UserId					INT
,	@ActionDescription		VARCHAR(1000)
AS

INSERT INTO ActivityUser
(
	UserId
,	ActionDescription
,	ActionDate
)
VALUES
(
	@UserId
,	@ActionDescription
,	Getdate()
)
SELECT @@IDENTITY AS Id
