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

INSERT INTO Banner
(
    BannerTypeId
,   Url
,   RedirectTo
)
VALUES
(
    1
,   './img/banner/teste.png'
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
,   './Video/001.mp4'
,   1
)

INSERT INTO Modules (Name) VALUES ('Banner')
INSERT INTO Modules (Name) VALUES ('User')
INSERT INTO Modules (Name) VALUES ('Profile')

INSERT INTO Profile (NAME) VALUES ('Administrator')
INSERT INTO Profile (NAME) VALUES ('User')

TRUNCATE TABLE [User]
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
    'Fernanda Lima'
,   'rickyteck@hotmail.com'
,   5511911111111
,   'Thot2020..'
,   2
,   'feeny_lima'
)
GO

INSERT INTO [ConnectionStatus] (NAME) VALUES ('Requested')
INSERT INTO [ConnectionStatus] (NAME) VALUES ('Approved')
INSERT INTO [ConnectionStatus] (NAME) VALUES ('Blocked')
INSERT INTO [ConnectionStatus] (NAME) VALUES ('Pending')
