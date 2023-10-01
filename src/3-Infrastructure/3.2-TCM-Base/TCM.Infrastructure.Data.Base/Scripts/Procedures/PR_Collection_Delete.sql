CREATE PROCEDURE [dbo].[PR_Collection_Delete]
	@Id				INT
AS
	UPDATE Collection SET Enabled = 0, ChangedDate = GETDATE() WHERE Id = @Id

