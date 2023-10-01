CREATE PROCEDURE [dbo].[PR_Connection_Status_Update]
	@Id					INT
,	@ConnectionStatusId	INT
AS
UPDATE 
	Connection
SET
	ConnectionStatusId	= @ConnectionStatusId
,	ChangedDate			= GETDATE()
WHERE
	Id = @Id