CREATE PROCEDURE [dbo].[PR_Banner_Insert]
	@BannerTypeId				INT
,	@BannerUrl					VARCHAR(200)
,	@BannerRedirectTo			VARCHAR(200) = NULL
AS

UPDATE Banner
SET
	Enabled = 0
,	ChangedDate = GETDATE()
WHERE
	BannerTypeId	= @BannerTypeId
AND Enabled			= 1

INSERT INTO Banner
(
	BannerTypeId
,	Url
,	RedirectTo
)
VALUES
(
	@BannerTypeId
,	@BannerUrl
,	@BannerRedirectTo
)
SELECT @@IDENTITY AS Id
