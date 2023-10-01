/*
Post-Deployment Script Template							
--------------------------------------------------------------------------------------
 This file contains SQL statements that will be appended to the build script.		
 Use SQLCMD syntax to include a file in the post-deployment script.			
 Example:      :r .\myfile.sql								
 Use SQLCMD syntax to reference a variable in the post-deployment script.		
 Example:      :setvar TableName MyTable							
               SELECT * FROM [$(TableName)]					
--------------------------------------------------------------------------------------
*/
TRUNCATE TABLE BannerType
INSERT INTO BannerType
(
    Type
,   Width
,   Height
)
VALUES
(
    'Top'
,   375
,   70
)


INSERT INTO BannerType
(
    Type
,   Width
,   Height
)
VALUES
(
    'Middle'
,   375
,   200
)
TRUNCATE TABLE Banner
INSERT INTO Banner
(
    BannerTypeId
,   Url
,   RedirectTo
)
VALUES
(
    1
,   '../../img/banner/teste.png'
,   'http://www.globo.com'
)
GO

INSERT INTO Banner
(
    BannerTypeId
,   Url
,   Video
)
VALUES
(
    2
,   '../../Video/001.mp4'
,   1
)
TRUNCATE TABLE Modules
INSERT INTO Modules (Name) VALUES ('Banner')
INSERT INTO Modules (Name) VALUES ('User')
INSERT INTO Modules (Name) VALUES ('Profile')

TRUNCATE TABLE Profile
INSERT INTO Profile (NAME) VALUES ('Administrator')
INSERT INTO Profile (NAME) VALUES ('User')

TRUNCATE TABLE [User]
INSERT INTO [User](
    FullName
,   Email
,   MobilePhone
,   Password
,   ProfileId
,   UserName
)
VALUES
(
    'Chef Melo'
,   'testes@hotmail.com'
,   5511931171996
,   'Thot2020..'
,   1
,   'chef_melo'
)
GO
INSERT INTO [User](
    FullName
,   Email
,   MobilePhone
,   Password
,   ProfileId
,   UserName
)
VALUES
(
    'Ricardo Perdigão'
,   'ricardo.perdigao@rickytech.com.br'
,   5511931171996
,   'Thot2020..'
,   2
,   'rickytech'
)
GO
INSERT INTO [User](
    FullName
,   Email
,   MobilePhone
,   Password
,   ProfileId
,   UserName
)
VALUES
(
    'Maria Eduarda Perdigao'
,   'eliterickytech@hotmail.com'
,   5511911111111
,   'Thot2020..'
,   2
,   'elitetatinha'
)
GO
INSERT INTO [User](
    FullName
,   Email
,   MobilePhone
,   Password
,   ProfileId
,   UserName
)
VALUES
(
    'Rafaella Perdigao'
,   'rickyteck@hotmail.com'
,   5511911111111
,   'Thot2020..'
,   2
,   'fafalindinha'
)
TRUNCATE TABLE [ConnectionStatus]
INSERT INTO [ConnectionStatus] (NAME) VALUES ('Requested')
INSERT INTO [ConnectionStatus] (NAME) VALUES ('Approved')
INSERT INTO [ConnectionStatus] (NAME) VALUES ('Blocked')
INSERT INTO [ConnectionStatus] (NAME) VALUES ('Pending')
INSERT INTO [ConnectionStatus] (NAME) VALUES ('Canceled')
GO

TRUNCATE TABLE [CollectionType]
INSERT INTO [CollectionType] (Name, Quantity) VALUES ('Single page', 1)
INSERT INTO [CollectionType] (Name, Quantity) VALUES ('2x2 grid', 4)
INSERT INTO [CollectionType] (Name, Quantity) VALUES ('3x3 grid', 9)
GO

TRUNCATE TABLE CollectionItemType
INSERT INTO CollectionItemType (Name, Width, Height, IsCollectible) VALUES ('Large Image', 348,348, 1 )
INSERT INTO CollectionItemType (Name, Width, Height, IsCollectible) VALUES ('Medium Image', 174, 174, 1)
INSERT INTO CollectionItemType (Name, Width, Height, IsCollectible) VALUES ('Small Image', 116,116, 1)
INSERT INTO CollectionItemType (Name, Width, Height, IsCollectible) VALUES ('Mini Image', 80, 60, 0)
INSERT INTO CollectionItemType (Name, Width, Height, IsCollectible) VALUES ('Video', 0,0, 0)
INSERT INTO CollectionItemType (Name, Width, Height, IsCollectible) VALUES ('Background', 0, 0, 0)

GO
TRUNCATE TABLE Collection
INSERT INTO Collection (Name, ColletionTypeId, AvailableDate, IsPhysicalAward) VALUES ('Coleção Inverno',1, GETDATE(), 0)
INSERT INTO Collection (Name, ColletionTypeId, AvailableDate, IsPhysicalAward) VALUES ('Coleção Outono', 2, GETDATE(), 0)
INSERT INTO Collection (Name, ColletionTypeId, AvailableDate, IsPhysicalAward) VALUES ('Coleção Primavera', 2, GETDATE(), 0)
INSERT INTO Collection (Name, ColletionTypeId, AvailableDate, IsPhysicalAward) VALUES ('Coleção Verão',3, GETDATE(), 0)

GO
TRUNCATE TABLE CollectionItem
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Name, Sequence) VALUES
(1, 6, 'apresentação', 1, '../../img/collection/000001/00.png', 'Valentine’', 0 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Name, Sequence) VALUES
(1, 4, 'apresentação', 1, '../../img/collection/000001/00.png', 'Valentine’', 0 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(1, 1, 'Imagem unica do chef', 2, '../../img/collection/000001/01.png', 1 )

INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Name, Sequence) VALUES
(2, 6, 'apresentação', 1, '../../img/collection/000002/00.png', 'Charlotte', 0 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Name, Sequence) VALUES
(2, 4, 'apresentação', 1, '../../img/collection/000002/00.png', 'Charlotte', 0 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(2, 2, 'Imagem unica do chef', 4, '../../img/collection/000002/01.png', 1 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(2, 2, 'Imagem unica do chef', 5, '../../img/collection/000002/02.png', 2 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(2, 2, 'Imagem unica do chef', 2, '../../img/collection/000002/03.png', 3 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(2, 2, 'Imagem unica do chef', 3, '../../img/collection/000002/04.png', 4 )

INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Name, Sequence) VALUES
(3, 6, 'apresentação', 1, '../../img/collection/000003/00.jpg', 'Wedding', 0 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Name, Sequence) VALUES
(3, 4, 'apresentação', 1, '../../img/collection/000003/00.jpg', 'Wedding', 0 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(3, 2, 'Imagem unica do chef', 2, '../../img/collection/000003/01.png', 1 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(3, 2, 'Imagem unica do chef', 3, '../../img/collection/000003/02.png', 2 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(3, 2, 'Imagem unica do chef', 4, '../../img/collection/000003/03.png', 3 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(3, 2, 'Imagem unica do chef', 5, '../../img/collection/000003/04.png', 4 )

INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Name, Sequence) VALUES
(4, 6, 'apresentação', 1, '../../img/collection/000004/00.jpg', 'Peachy', 0 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Name, Sequence) VALUES
(4, 4, 'apresentação', 1, '../../img/collection/000004/00.jpg', 'Peachy', 0 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(4, 3, 'Imagem unica do chef', 2, '../../img/collection/000004/01.png', 1 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(4, 3, 'Imagem unica do chef', 3, '../../img/collection/000004/02.png', 2 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(4, 3, 'Imagem unica do chef', 4, '../../img/collection/000004/03.png', 3 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(4, 3, 'Imagem unica do chef', 5, '../../img/collection/000004/04.png', 4 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(4, 3, 'Imagem unica do chef', 6, '../../img/collection/000004/05.png', 5 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(4, 3, 'Imagem unica do chef', 7, '../../img/collection/000004/06.png', 6 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(4, 3, 'Imagem unica do chef', 8, '../../img/collection/000004/07.png', 7 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(4, 3, 'Imagem unica do chef', 9, '../../img/collection/000004/08.png', 8 )
INSERT INTO CollectionItem (CollectionId, CollectionItemTypeId, Description, Sort, Url, Sequence) VALUES
(4, 3, 'Imagem unica do chef', 10, '../../img/collection/000004/09.png', 9 )


TRUNCATE TABLE CollectionUser
INSERT INTO CollectionUser (CollectionItemId, UserId, CollectionId) VALUES (3, 2, 1)

INSERT INTO CollectionUser (CollectionItemId, UserId, CollectionId) VALUES (6, 2, 2)

INSERT INTO CollectionUser (CollectionItemId, UserId, CollectionId) VALUES (8, 2, 2)
INSERT INTO CollectionUser (CollectionItemId, UserId, CollectionId) VALUES (9, 2, 2)

INSERT INTO CollectionUser (CollectionItemId, UserId, CollectionId) VALUES (12, 2, 3)

INSERT INTO CollectionUser (CollectionItemId, UserId, CollectionId) VALUES (18, 2, 4)
INSERT INTO CollectionUser (CollectionItemId, UserId, CollectionId) VALUES (19, 2, 4)

TRUNCATE TABLE CollectionItemShared
INSERT INTO CollectionItemShared (UserId, ConnectionUserId, CollectionItemId) VALUES (1, 2, 3)
INSERT INTO CollectionItemShared (UserId, ConnectionUserId, CollectionItemId) VALUES (1, 2, 3)
INSERT INTO CollectionItemShared (UserId, ConnectionUserId, CollectionItemId) VALUES (1, 2, 6)
INSERT INTO CollectionItemShared (UserId, ConnectionUserId, CollectionItemId) VALUES (1, 2, 8)
INSERT INTO CollectionItemShared (UserId, ConnectionUserId, CollectionItemId) VALUES (1, 2, 8)
INSERT INTO CollectionItemShared (UserId, ConnectionUserId, CollectionItemId) VALUES (1, 2, 9)
INSERT INTO CollectionItemShared (UserId, ConnectionUserId, CollectionItemId) VALUES (1, 2, 12)
INSERT INTO CollectionItemShared (UserId, ConnectionUserId, CollectionItemId) VALUES (1, 2, 18)
INSERT INTO CollectionItemShared (UserId, ConnectionUserId, CollectionItemId) VALUES (1, 2, 19)
INSERT INTO CollectionItemShared (UserId, ConnectionUserId, CollectionItemId) VALUES (1, 2, 19)

TRUNCATE TABLE Chat
INSERT INTO Chat (UserId,ConnectionUserId,IsReaded, Message) VALUES (1, 2, 1,'OI')  
INSERT INTO Chat (UserId,ConnectionUserId,IsReaded, Message) VALUES (2, 1, 0,'TUDO BEM:?')  
INSERT INTO Chat (UserId,ConnectionUserId,IsReaded, Message) VALUES (2, 1, 0,'COMO VAI')  
INSERT INTO Chat (UserId,ConnectionUserId,IsReaded, Message) VALUES (2, 1, 0,'NICE TO MEET YOU')  

TRUNCATE TABLE Connection
INSERT INTO Connection (UserId, ConnectionUserId, ConnectionStatusId) VALUES (1, 2, 2)
INSERT INTO Connection (UserId, ConnectionUserId, ConnectionStatusId) VALUES (1, 3, 2)
INSERT INTO Connection (UserId, ConnectionUserId, ConnectionStatusId) VALUES (1, 4, 2)
