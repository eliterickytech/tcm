CREATE TABLE [dbo].[CollectionType]
(
	[Id] INT NOT NULL PRIMARY KEY IDENTITY(1,1)
,	Name VARCHAR(50) NOT NULL
,	Quantity		INT
,	Enabled BIT NOT NULL DEFAULT(1)
,	CreatedDate datetime not null default(getdate())
,	ChangedDate datetime null
)
