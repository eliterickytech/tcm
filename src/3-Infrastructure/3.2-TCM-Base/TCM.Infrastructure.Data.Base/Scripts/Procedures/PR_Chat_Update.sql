CREATE PROCEDURE [dbo].[PR_Chat_Update]
	@Id					INT 
,	@Message			VARCHAR(1000) = NULL
,	@Enabled			BIT = NULL
AS

UPDATE 
	Chat
SET
	Message = (
		CASE WHEN @Message IS NOT NULL THEN @Message ELSE Message END
	),
	Enabled = (
		CASE WHEN @Enabled IS NOT NULL THEN @Enabled ELSE Enabled END
	),
	ChangedDate = GETDATE()

WHERE
	Id = @Id
