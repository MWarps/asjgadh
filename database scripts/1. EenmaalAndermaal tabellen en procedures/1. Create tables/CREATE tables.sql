USE iproject
go

--kolom met gebruikersnaam als foreign key altijd genoemd gebruikersnaam

DROP TABLE IF EXISTS  Verkoper, Verificatie, Gebruikerstelefoon, Illustratie, Vragen, Voorwerp,  Rubrieken, Gebruiker, Landen, Verificatietypen ;
go
----------------------------------------------------------
-------------------- CREATE TABLES -----------------------
----------------------------------------------------------

CREATE TABLE Vragen (  
vraagnr				TINYINT			NOT NULL,  
vraag				VARCHAR(80)		NOT NULL,  
CONSTRAINT pk_vraagnr PRIMARY KEY(vraagnr)  
) 

CREATE TABLE Landen
(
  GBA_CODE		CHAR(4) NOT NULL,
  NAAM_LAND		VARCHAR(40) NOT NULL,
  BEGINDATUM	DATE NULL,
  EINDDATUM		DATE NULL,
  EER_Lid		BIT NOT NULL DEFAULT 0,
  CONSTRAINT PK_Landen PRIMARY KEY (GBA_CODE),
  CONSTRAINT UQ_Landen UNIQUE (NAAM_LAND),
  CONSTRAINT CHK_CODE CHECK ( LEN(GBA_CODE) = 4 ),
  CONSTRAINT CHK_DATUM CHECK ( BEGINDATUM < EINDDATUM )
);

CREATE TABLE Gebruiker (
gebruikersnaam		VARCHAR(50)		NOT NULL,
voornaam			VARCHAR(50)		NOT NULL,
achternaam			VARCHAR(51)		NOT NULL,
geslacht			CHAR(1)			NOT NULL,
adresregel1			VARCHAR(71)		NOT NULL,
adresregel2			VARCHAR(71)		NULL,
postcode			CHAR(7)			NOT NUll,
plaatsnaam			VARCHAR(28)		NOT NUll,
land				VARCHAR(40)		NOT NULL,
geboortedatum		Date			NOT NULL,
email				VARCHAR(254)	NOT NULL,
wachtwoord			VARCHAR(100)	NOT NULL,
vraag				TINYINT			NOT NULL,
antwoordtekst		VARCHAR(50)		NOT NULL,
verkoper			bit				NOT NUll,
beheerder			bit				NOT NULL DEFAULT 0,
geblokeerd			bit				NOT NULL DEFAULT 0,
CONSTRAINT PK_Gebruiker PRIMARY KEY (gebruikersnaam),
CONSTRAINT CK_gebruiker_geslacht CHECK (geslacht IN ( 'M','F','X') ),
CONSTRAINT UQ_gebruiker_email UNIQUE(email),
CONSTRAINT CK_Email check (email like'%_@__%.__%'),
CONSTRAINT CK_voornaam		CHECK ( voornaam not like	'%[0-9]%'),
CONSTRAINT CK_achternaam	CHECK ( achternaam not like '%[0-9]%'),
CONSTRAINT CK_plaatsnaam	CHECK ( plaatsnaam not like '%[0-9]%')
);

CREATE TABLE Verkoper (
gebruikersnaam		VARCHAR(50)		NOT NULL,
bank				CHAR(4)			NOT NULL,
bankrekeningnummer	CHAR(18)		NOT NULL,
--controle optie nog niet duidelijk
creditcard			CHAR(19)		NULL,
CONSTRAINT PK_Verkoper PRIMARY KEY (gebruikersnaam)
);

CREATE TABLE Gebruikerstelefoon (
volgnr				INT				NOT NULL,
gebruikersnaam		VARCHAR(50)		NOT NULL,
telefoon			VARCHAR(15)		NOT NULL,
CONSTRAINT PK_Gebruikerstelefoon PRIMARY KEY (volgnr, gebruikersnaam),
CONSTRAINT CK_telefoon CHECK (telefoon NOT LIKE '%[a-z]%')
);

CREATE TABLE Verificatietypen (
verificatietype		CHAR(5)			NOT NULL,
CONSTRAINT PK_Verificatietypen PRIMARY KEY (verificatietype)
);

CREATE TABLE Verificatie (
email				VARCHAR(254)	NOT NULL,
type				CHAR(5)			NOT NULL,
verificatiecode		INT				NOT NULL,
eindtijd			SMALLDATETIME	NOT NULL,
CONSTRAINT PK_Verificatie PRIMARY KEY (email)
);

CREATE TABLE Voorwerp (
voorwerpnr			bigint			NOT NULL,
titel				varchar(100)	NOT NULL,
beschrijving		varchar(max)	NOT NULL,
startprijs			varchar(9)		NOT NULL,
betalingswijze		varchar(20)		NOT NULL,
betalingsinstructie	varchar(70)		NULL,
plaatsnaam			varchar(28)		NOT NULL,
land				CHAR(4)			NOT NULL,
looptijd			tinyint			NOT NULL,
looptijdbegindagtijdstip datetime	NOT NULL,
verzendkosten		varchar(9)		NULL,
verzendinstructies	varchar(70)		NULL,
verkoper			varchar(50)		NOT NULL,
koper				varchar(50)		NULL,
looptijdeindedagtijdstip datetime	NOT NULL,
veilinggesloten		bit				NOT NULL,
verkoopprijs		varchar(9)		NULL
CONSTRAINT PK_voorwerpnr PRIMARY KEY (voorwerpnr)
);

CREATE TABLE Illustratie
(
	voorwerpnr bigint NOT NULL,
	IllustratieFile varchar(100) NOT NULL,
    CONSTRAINT PK_ItemPlaatjes PRIMARY KEY (voorwerpnr, IllustratieFile)
)

CREATE TABLE Rubrieken (
rubrieknummer		INT				NOT NULL,
rubrieknaam			VARCHAR(100)	NOT NULL,
superrubriek		INT				NULL,
volgnr				TINYINT			NOT NULL
CONSTRAINT PK_rubrieknummer PRIMARY KEY (rubrieknummer)
);

CREATE TABLE Bod (
euro				VARCHAR(9)		NOT NULL,
datumentijd			Datetime		NOT NULL,
gebruikersnaam		VARCHAR(50)		NOT NULL,
voorwerpnr			BIGINT			NOT NULL,
CONSTRAINT PK_bod PRIMARY KEY (euro, voorwerpnr)
);

----------------------------------------------------------
-------------------- ALTER TABLES ------------------------
----------------------------------------------------------

ALTER TABLE Voorwerp ADD
CONSTRAINT FK_Verkoper 
	FOREIGN KEY (verkoper) REFERENCES Gebruiker(gebruikersnaam)
	ON UPDATE CASCADE
	ON DELETE NO ACTION

ALTER TABLE Illustratie ADD
CONSTRAINT voorwerpnrVanPlaatjes
	FOREIGN KEY(voorwerpnr) REFERENCES Voorwerp(voorwerpnr)
	ON UPDATE CASCADE
	ON DELETE NO ACTION

ALTER TABLE Gebruiker ADD 
CONSTRAINT FK_Vraag 
	FOREIGN KEY (vraag) REFERENCES Vragen(vraagnr)
	ON UPDATE CASCADE
	ON DELETE NO ACTION,
CONSTRAINT FK_Gebruikerland 
	FOREIGN KEY (land) REFERENCES Landen(NAAM_LAND)
	ON UPDATE CASCADE
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
	ON UPDATE CASCADE
	ON DELETE CASCADE,
CONSTRAINT FK_Bod_Voorwerp
	FOREIGN KEY (voorwerpnr) REFERENCES Voorwerp(voorwerpnr)
	ON UPDATE CASCADE
	ON DELETE CASCADE
