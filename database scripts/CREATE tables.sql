USE EenmaalAndermaal

DROP TABLE IF EXISTS Verificatie, Verificatietypen, Gebruiker, Vragen, Verkoper;

CREATE TABLE Vragen (  
vraagnr Tinyint NOT NULL,  
vraag VARCHAR(80) NOT NULL,  
CONSTRAINT pk_vraagnr PRIMARY KEY(vraagnr)  
) 

CREATE TABLE Gebruiker (
gebruikersnaam VARCHAR(50) NOT NULL,
voornaam VARCHAR(50) NOT NULL,
achternaam VARCHAR(51) NOT NULL,
adresregel1 VARCHAR(71) NOT NULL,
adresregel2 VARCHAR(71) NULL,
postcode CHAR(7) NOT NUll,
plaatsnaam VARCHAR(28) NOT NUll,
land VARCHAR(9) NOT NULL,
geboortedatum Date NOT NULL,
email VARCHAR(254) NOT NULL,
wachtwoord VARCHAR(100) NOT NULL,
vraag Tinyint NOT NULL,
antwoordtekst VARCHAR(50) NOT NULL,
verkoper bit NOT NUll,
CONSTRAINT PK_Gebruiker PRIMARY KEY (gebruikersnaam)
);

CREATE TABLE Verkoper (
gebruikersnaam VARCHAR(50) NOT NULL,
bank CHAR(4) NULL,
bankrekeningnummer CHAR(18) NULL,
--controle optie nog niet duidelijk
creditcard CHAR(19) NULL,
CONSTRAINT PK_Verkoper PRIMARY KEY (gebruikersnaam)
);

CREATE TABLE Verificatietypen (
verificatietype CHAR(4) NOT NULL,
CONSTRAINT PK_Verificatietypen PRIMARY KEY (verificatietype)
);

CREATE TABLE Verificatie (
gebruikersnaam VARCHAR(50) NOT NULL,
type CHAR(4) NOT NULL,
verificatiecode CHAR(6) NOT NULL,
eindtijd Smalldatetime NOT NULL,
CONSTRAINT PK_Verificatie PRIMARY KEY (gebruikersnaam)
);

ALTER TABLE Gebruiker ADD 
CONSTRAINT FK_Vraag 
	FOREIGN KEY (vraag) REFERENCES Vragen(vraagnr)
	ON UPDATE CASCADE
	ON DELETE NO ACTION

ALTER TABLE Verkoper ADD
CONSTRAINT FK_Gebruiker
	FOREIGN KEY (gebruikersnaam) REFERENCES Gebruiker(gebruikersnaam)
	ON UPDATE CASCADE
	ON DELETE CASCADE

ALTER TABLE Verificatie ADD
CONSTRAINT FK_Verificatietype
	FOREIGN KEY (type) REFERENCES Verificatietypen(verificatietype)
	ON UPDATE CASCADE
	ON DELETE CASCADE
