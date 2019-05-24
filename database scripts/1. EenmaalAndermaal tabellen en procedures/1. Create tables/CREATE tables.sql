--USE iproject
go

--kolom met gebruikersnaam als foreign key altijd genoemd gebruikersnaam

DROP TABLE IF EXISTS  Voorwerpinrubriek, Bod,  Rubrieken, Illustratie,  Voorwerp, Verificatie, Verificatietypen, Gebruikerstelefoon, Verkoper, Gebruiker, Landen, Vragen ;
go
----------------------------------------------------------
-------------------- CREATE TABLES -----------------------
----------------------------------------------------------

CREATE TABLE Vragen 
(  
vraagnr				TINYINT			NOT NULL,  
vraag				VARCHAR(80)		NOT NULL,  
CONSTRAINT pk_vraagnr PRIMARY KEY(vraagnr)  
) 

CREATE TABLE Landen
(
  GBA_CODE			CHAR(4)			NOT NULL,
  NAAM_LAND			VARCHAR(40)		NOT NULL,
  BEGINDATUM		DATE			NULL,
  EINDDATUM			DATE			NULL,
  EER_Lid			BIT				NOT NULL DEFAULT 0,
  CONSTRAINT PK_Landen PRIMARY KEY (GBA_CODE),
  CONSTRAINT UQ_Landen UNIQUE (NAAM_LAND),
  CONSTRAINT CHK_CODE CHECK ( LEN(GBA_CODE) = 4 ),
  CONSTRAINT CHK_DATUM CHECK ( BEGINDATUM < EINDDATUM )
);

CREATE TABLE Gebruiker 
(
gebruikersnaam		VARCHAR(50)		NOT NULL,
voornaam			VARCHAR(50)		NOT NULL,
achternaam			VARCHAR(51)		NOT NULL,
geslacht			CHAR(1)			NOT NULL,
adresregel1			VARCHAR(71)		NOT NULL,
adresregel2			VARCHAR(71)		NULL,
postcode			CHAR(7)			NOT NUll,
plaatsnaam			VARCHAR(28)		NOT NUll,
land				VARCHAR(40)		NOT NULL,
geboortedatum		DATE			NOT NULL,
email				VARCHAR(254)	NOT NULL,
wachtwoord			VARCHAR(100)	NOT NULL,
vraag				TINYINT			NOT NULL,
antwoordtekst		VARCHAR(50)		NOT NULL,
verkoper			BIT				NOT NUll,
beheerder			BIT				NOT NULL DEFAULT 0,
geblokeerd			BIT				NOT NULL DEFAULT 0,
gezien				BIT				NOT NULL DEFAULT 0
CONSTRAINT PK_Gebruiker PRIMARY KEY (gebruikersnaam),
CONSTRAINT CK_gebruiker_geslacht CHECK (geslacht IN ( 'M','F','X') ),
CONSTRAINT UQ_gebruiker_email UNIQUE(email),
CONSTRAINT CK_Email check (email like'%_@__%.__%'),
CONSTRAINT CK_voornaam		CHECK ( voornaam not like	'%[0-9]%'),
CONSTRAINT CK_achternaam	CHECK ( achternaam not like '%[0-9]%'),
CONSTRAINT CK_plaatsnaam	CHECK ( plaatsnaam not like '%[0-9]%')
);

CREATE TABLE Verkoper 
(
gebruikersnaam		VARCHAR(50)		NOT NULL,
bank				CHAR(4)			NOT NULL,
bankrekeningnummer	CHAR(18)		NOT NULL,
--controle optie nog niet duidelijk
creditcard			CHAR(19)		NULL,
gevalideerd			BIT				NOT NULL default 0
CONSTRAINT PK_Verkoper PRIMARY KEY (gebruikersnaam)
);

CREATE TABLE Gebruikerstelefoon (
volgnr				INT				NOT NULL,
gebruikersnaam		VARCHAR(50)		NOT NULL,
telefoon			VARCHAR(15)		NOT NULL,
CONSTRAINT PK_Gebruikerstelefoon PRIMARY KEY (volgnr, gebruikersnaam),
CONSTRAINT CK_telefoon CHECK (telefoon NOT LIKE '%[a-z]%')
);

CREATE TABLE Verificatietypen 
(
verificatietype		CHAR(5)			NOT NULL,
CONSTRAINT PK_Verificatietypen PRIMARY KEY (verificatietype)
);

CREATE TABLE Verificatie 
(
email				VARCHAR(254)	NOT NULL,
type				CHAR(5)			NOT NULL,
verificatiecode		INT				NOT NULL,
eindtijd			SMALLDATETIME	NOT NULL,
CONSTRAINT PK_Verificatie PRIMARY KEY (email)
);

CREATE TABLE Voorwerp (
voorwerpnr			BIGINT			IDENTITY(1,1),
titel				VARCHAR(100)	NOT NULL,
beschrijving		VARCHAR(max)	NOT NULL,
startprijs			VARCHAR(9)		NOT NULL,
betalingswijze		VARCHAR(20)		NOT NULL,
betalingsinstructie	VARCHAR(70)		NULL,
plaatsnaam			VARCHAR(28)		NOT NULL,
land				VARCHAR(40)		NOT NULL,
looptijd			TINYINT			NOT NULL,
looptijdbegindagtijdstip DATETIME	NOT NULL DEFAULT CURRENT_TIMESTAMP,
verzendkosten		VARCHAR(9)		NULL,
verzendinstructies	VARCHAR(70)		NULL,
verkoper			VARCHAR(50)		NOT NULL,
koper				VARCHAR(50)		NULL,
looptijdeindedagtijdstip DATETIME	NOT NULL,
veilinggesloten		BIT				NOT NULL DEFAULT 0,
verkoopprijs		VARCHAR(9)		NULL,
gezien				INT				NOT NULL DEFAULT 0,
geblokkeerd			BIT				NOT NULL DEFAULT 0,
blokkeerdatum		DATE			NULL,
CONSTRAINT PK_voorwerpnr PRIMARY KEY (voorwerpnr)
);

CREATE TABLE Illustratie
(
	voorwerpnr		BIGINT			NOT NULL,
	IllustratieFile VARCHAR(100)	NOT NULL,
    CONSTRAINT PK_ItemPlaatjes PRIMARY KEY (voorwerpnr, IllustratieFile)
)

--CREATE INDEX IX_Items_Categorie ON Items (Categorie)			Tabel Rubriek
--CREATE INDEX IX_Categorieen_Parent ON Categorieen (Parent)	Tabel Rubriek

CREATE TABLE Rubrieken 
(
rubrieknummer		INT				NOT NULL,
rubrieknaam			VARCHAR(100)	NOT NULL,
superrubriek		INT				NULL,
volgnr				INT				NOT NULL
CONSTRAINT PK_rubrieknummer PRIMARY KEY (rubrieknummer)
);

CREATE TABLE Bod 
(
euro				VARCHAR(9)		NOT NULL,
datumentijd			DATETIME		NOT NULL DEFAULT CURRENT_TIMESTAMP,
gebruikersnaam		VARCHAR(50)		NOT NULL,
voorwerpnr			BIGINT			NOT NULL,
CONSTRAINT PK_bod PRIMARY KEY (euro, voorwerpnr)
);

CREATE TABLE Voorwerpinrubriek
(
voorwerpnr			BIGINT			NOT NULL,
rubrieknr			INT				NOT NULL,
CONSTRAINT PK_voorwerpintabel PRIMARY KEY (voorwerpnr, rubrieknr)
);

CREATE TABLE Laatstbekeken
(
gebruikersnaam		VARCHAR(50)		NOT NULL,
voorwerpnr			BIGINT			NOT NULL,
datumtijd			DATETIME		NOT NULL DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT PK_laatstbekeken PRIMARY KEY (gebruikersnaam, voorwerpnr, datumtijd)
);

CREATE TABLE Aanbevolen
(
gebruikersnaam		VARCHAR(50)		NOT NULL,
rubrieknr			INT				NOT NULL,
datumtijd			DATETIME		NOT NULL DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT PK_laatstbekeken PRIMARY KEY (gebruikersnaam, rubrieknr, datumtijd)
);

----------------------------------------------------------
-------------------- ALTER TABLES ------------------------
----------------------------------------------------------


ALTER TABLE Voorwerp ADD
CONSTRAINT FK_Verkoper 
	FOREIGN KEY (verkoper) REFERENCES Gebruiker(gebruikersnaam)
	ON UPDATE CASCADE
	ON DELETE CASCADE,
CONSTRAINT FK_VoorwerpLand
	FOREIGN KEY (land) REFERENCES Landen(NAAM_LAND)
	ON UPDATE CASCADE
	ON DELETE NO ACTION

ALTER TABLE Illustratie ADD
CONSTRAINT FK_voorwerpnrVanPlaatjes
	FOREIGN KEY(voorwerpnr) REFERENCES Voorwerp(voorwerpnr)
	ON UPDATE CASCADE
	ON DELETE CASCADE

ALTER TABLE Gebruiker ADD 
CONSTRAINT FK_Vraag 
	FOREIGN KEY (vraag) REFERENCES Vragen(vraagnr)
	ON UPDATE CASCADE
	ON DELETE NO ACTION,
CONSTRAINT FK_Gebruikerland
	FOREIGN KEY (land) REFERENCES Landen(NAAM_LAND)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
go

ALTER TABLE Verkoper ADD
CONSTRAINT FK_Gebruiker
	FOREIGN KEY (gebruikersnaam) REFERENCES Gebruiker(gebruikersnaam)
	ON UPDATE CASCADE
	ON DELETE CASCADE
go

ALTER TABLE Gebruikerstelefoon ADD
CONSTRAINT FK_Gebruikerstelefoon
	FOREIGN KEY (gebruikersnaam) REFERENCES Gebruiker(gebruikersnaam)
	ON UPDATE CASCADE
	ON DELETE CASCADE
go

ALTER TABLE Verificatie ADD
CONSTRAINT FK_Verificatietype
	FOREIGN KEY (type) REFERENCES Verificatietypen(verificatietype)
	ON UPDATE CASCADE
	ON DELETE CASCADE
go

ALTER TABLE Bod ADD
CONSTRAINT FK_Bod_Gebruiker
	FOREIGN KEY (gebruikersnaam) REFERENCES Gebruiker(gebruikersnaam)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION,
CONSTRAINT FK_Bod_Voorwerp
	FOREIGN KEY (voorwerpnr) REFERENCES Voorwerp(voorwerpnr)
	ON UPDATE CASCADE
	ON DELETE CASCADE
go

ALTER TABLE Voorwerpinrubriek ADD
CONSTRAINT FK_voorwerpintabel_voorwerp
	FOREIGN KEY (voorwerpnr) REFERENCES Voorwerp(voorwerpnr)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION,
CONSTRAINT FK_voorwerpintabel_rubriek 
	FOREIGN KEY (rubrieknr) REFERENCES Rubrieken(rubrieknummer)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
go

ALTER TABLE Laatstbekeken ADD
CONSTRAINT FK_laatstbekeken_gebruiker
	FOREIGN KEY (gebruikersnaam) REFERENCES Gebruiker(gebruikersnaam)
	ON UPDATE CASCADE
	ON DELETE CASCADE,
CONSTRAINT FK_laatstbekeken_voorwerp
	FOREIGN KEY (voorwerpnr) REFERENCES Voorwerp(voorwerpnr)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
go

ALTER TABLE Aanbevolen ADD
CONSTRAINT FK_aanbevolen_gebruiker
	FOREIGN KEY (gebruikersnaam) REFERENCES Gebruiker(gebruikersnaam)
	ON UPDATE CASCADE
	ON DELETE CASCADE,
CONSTRAINT FK_aanbevolen_rubriek
	FOREIGN KEY (rubrieknr) REFERENCES Rubrieken(rubrieknummer)
	ON UPDATE NO ACTION
	ON DELETE NO ACTION
go