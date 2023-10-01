CREATE PROCEDURE [dbo].[PR_Connection_Delete]
	@Id				INT
,	@ConnectionStatusId	INT
AS
UPDATE 
	Connection
SET	
	Enabled = 0
,	ConnectionStatusId = @ConnectionStatusId
,	ChangedDate = GETDATE()
WHERE	
	Id = @Id