CREATE TABLE [dbo].[CollectionItemType]
(
	[Id] INT NOT NULL PRIMARY KEY identity(1,1), 
    [Name] VARCHAR(50) NOT NULL, 
    Width int null,
    Height int null,
    IsCollectible bit not null default(0),
    [Enabled] bit not null default 1,
    [CreatedDate] DATETIME NOT NULL DEFAULT getdate()
)
