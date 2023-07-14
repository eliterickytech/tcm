CREATE PROCEDURE [dbo].[PR_Banner_Insert]
	@BannerTypeId				INT
,	@BannerUrl					VARCHAR(200)
,	@BannerRedirectTo			VARCHAR(200) = NULL
AS
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
