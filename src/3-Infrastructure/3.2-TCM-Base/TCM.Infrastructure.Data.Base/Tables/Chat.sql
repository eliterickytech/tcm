CREATE TABLE [dbo].[Chat]
(
	[Id] INT NOT NULL PRIMARY KEY	IDENTITY(1,1)
,	[UserId]				INT NOT NULL 
,	[ConnectionUserId]		INT NOT NULL
,   [Message]               VARCHAR(1000) NOT NULL
,	[IsReaded]				BIT NOT NULL DEFAULT 0, 
    [Enabled] BIT NOT NULL DEFAULT 1, 
    [CreatedDate] DATETIME NOT NULL DEFAULT getdate(), 
    [ChangedDate] DATETIME NULL
,	
)
