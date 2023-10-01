CREATE PROCEDURE [dbo].[PR_User_Adm_Delete]
	@Id				INT
AS
UPDATE 
	[User]
SET ProfileId = 2
,	ChangedDate = GETDATE()
WHERE ID = @Id

