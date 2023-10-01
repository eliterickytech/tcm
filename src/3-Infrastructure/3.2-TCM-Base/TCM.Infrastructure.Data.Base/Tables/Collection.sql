CREATE TABLE [dbo].[Collection]
(
	[Id] INT NOT NULL PRIMARY KEY IDENTITY(1,1)
,	ColletionTypeId int not null
,	Name varchar(100)
,	AvailableDate datetime default(getdate()) NOT NULL, 
    [IsPhysicalAward] BIT NOT NULL DEFAULT (0), 
    [Enabled] BIT NOT NULL DEFAULT (1), 
    [CreatedDate] DATETIME NOT NULL DEFAULT getdate(), 
    [ChangedDate] DATETIME NULL
,	
)
