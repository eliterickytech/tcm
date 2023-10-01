CREATE TABLE [dbo].[CollectionUser]
(
	[Id] INT NOT NULL PRIMARY KEY IDENTITY(1,1), 
    [CollectionItemId] INT NOT NULL, 
    [CollectionId]      INT NOT NULL,
    [UserId] INT NOT NULL, 
    [Enabled] BIT NOT NULL DEFAULT 1, 
    [CreatedDate] DATETIME NOT NULL DEFAULT getdate()

)
