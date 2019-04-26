// script om de tabellen te maken

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
wachtwoord VARCHAR(28) NOT NULL,
vraag Tinyint NOT NULL,
antwoordtekst VARCHAR(50) NOT NULL,
verkoper bit NOT NUll,
CONSTRAINT PK_Gebruiker PRIMARY KEY (gebruikersnaam),

);

