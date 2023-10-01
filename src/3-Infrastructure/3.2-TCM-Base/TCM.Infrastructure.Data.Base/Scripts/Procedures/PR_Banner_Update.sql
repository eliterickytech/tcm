CREATE PROCEDURE [dbo].[PR_Banner_Update]
	@BannerId					INT
,	@BannerUrl					VARCHAR(200)
,	@BannerRedirectTo			VARCHAR(200) = NULL

AS
UPDATE
	Banner
SET 
	Url			= @BannerUrl
,	RedirectTo	= @BannerRedirectTo
,	ChangedDate	= GETDATE()

WHERE 
	Id			= @BannerId
