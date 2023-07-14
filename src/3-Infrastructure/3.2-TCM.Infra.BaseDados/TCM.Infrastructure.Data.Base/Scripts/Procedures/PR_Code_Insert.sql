CREATE PROCEDURE [dbo].[PR_Code_Insert]
	@User                 VARCHAR(100)
,   @Code                 VARCHAR(100) 
AS
    DECLARE @UserId INT
    SELECT @UserId = Id FROM [User] WHERE Email = @User AND Enabled = 1

    INSERT INTO MFACode
        (UserId, Code)
    VALUES
        (@Userid, @Code)