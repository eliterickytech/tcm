CREATE TABLE [dbo].[CollectionItem]
(
	[Id] INT NOT NULL PRIMARY KEY identity(1,1),
	[CollectionId] INT NOT NULL, 
    [CollectionItemTypeId] INT NOT NULL, 
    [Url] VARCHAR(250) NOT NULL, 
    [Sequence] INT,
    [Sort] INT NOT NULL, 
    [Quantity] INT NULL,
    [Description] VARCHAR(200) NOT NULL, 
    [Name] VARCHAR(100) NULL,
    [Enabled] BIT NOT NULL DEFAULT 1, 
    [CreatedDate] DATETIME NOT NULL DEFAULT getdate(), 
    [ChangedDate] DATETIME NULL
)
