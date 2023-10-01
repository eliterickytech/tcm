CREATE PROCEDURE [dbo].[PR_User_Adm_Insert]
	@Id			INT
AS
UPDATE [User] SET ProfileId = 1 WHERE ID = @Id