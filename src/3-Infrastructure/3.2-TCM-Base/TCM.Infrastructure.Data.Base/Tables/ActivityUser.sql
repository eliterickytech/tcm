CREATE TABLE [dbo].[ActivityUser]
(
	[Id] INT NOT NULL PRIMARY KEY IDENTITY(1,1), 
    [UserId] INT NOT NULL, 
    [ActionDescription] varchar(1000) not null,
    [ActionDate] DATETIME NOT NULL DEFAULT getdate(), 
    CONSTRAINT [fk_UserId] FOREIGN KEY ([UserId]) REFERENCES [User]([Id])

)


