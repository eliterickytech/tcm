CREATE PROCEDURE [dbo].[PR_Banner_Select]
WITH RECOMPILE	
AS
	SELECT 
		Banner.Id					AS BannerId
	,	Banner.RedirectTo			AS BannerRedirectTo
	,	Banner.Url					AS BannerUrl
	,	BannerType.Id				AS BannerTypeId
	,	BannerType.Type				AS BannerTypeType
	,	Banner.Video				AS BannerVideo
	,	BannerType.Width			AS BannerTypeWidth
	,	BannerType.Height			AS BannerTypeHeight
	,	Banner.CreatedDate			AS BannerTypeCreatedDate
	,	Banner.ChangedDate			AS BannerTypeChangedDate
	FROM

		BannerType

			INNER JOIN
			Banner
			ON BannerType.Id = Banner.BannerTypeId

	WHERE
		Banner.Enabled = 1