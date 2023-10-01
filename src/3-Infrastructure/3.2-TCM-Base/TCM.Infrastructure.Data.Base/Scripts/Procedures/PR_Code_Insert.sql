CREATE PROCEDURE [dbo].[PR_Code_Insert]
	@UserId               INT
,   @Code                 VARCHAR(100) 
AS

    INSERT INTO MFACode
        (UserId, Code)
    VALUES
        (@Userid, @Code)