CREATE TABLE [dbo].[CollectionItemShared]
(
	[Id] INT NOT NULL PRIMARY KEY identity(1,1),
	[UserId] INT NOT NULL, 
    [ConnectionUserId] INT NOT NULL, 
    [CollectionItemId] INT NOT NULL, 
    [Enabled] BIT NOT NULL DEFAULT 1, 
    [CreatedDate] DATETIME NOT NULL DEFAULT getdate(), 
    [ChangedDate] DATETIME NULL

)
