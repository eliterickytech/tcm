CREATE TABLE [dbo].[Connection]
(
	[Id] INT NOT NULL PRIMARY KEY			IDENTITY(1,1)
,	[UserId]			INT NOT NULL
,	[ConnectionUserId]		INT NOT NULL
,	[ConnectionStatusId]				INT NOT NULL DEFAULT 1
,	Enabled				BIT NOT NULL DEFAULT(1), 
    [CreatedDate] DATETIME NOT NULL DEFAULT GETDATE(), 
    [ChangedDate] NCHAR(10) NULL
,	
)
