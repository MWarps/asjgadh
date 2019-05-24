delete from dbo.Gebruiker
delete from dbo.Rubrieken
delete from dbo.Voorwerp
delete from dbo.Illustratie

INSERT INTO dbo.Gebruiker (gebruikersnaam, voornaam, achternaam, geslacht, adresregel1, adresregel2, postcode, plaatsnaam, 
land, geboortedatum, email, wachtwoord, vraag, antwoordtekst, verkoper, beheerder, geblokeerd, gezien)
SELECT DISTINCT 
LEFT(Username, 50)	AS gebruikersnaam,
' '					AS voornaam, -- is niet bekend bij ebay
' '					AS achternaam, -- is niet bekend bij ebay
'X'					AS geslacht,
Location			AS adresregel1, 
NULL				AS adresregel2,
Postalcode			AS postcode, -- niet overal gestandaardiseerd
Location	AS plaatsnaam, -- is vaak het land plaatsnaam is maar bij sommige gebruikers bekend
Location			AS land, --country code query !!!!!!
'20000101'			AS geboortedatum, -- is niet bekend bij ebay
CONCAT('asjgadh+', Username, '@gmail.com') AS email, -- email naam nog niet final
'$2y$10$Ggqn9ZFypjDNwTi.e0WSj.HRyB5SoycCDtef2AnuCY5y5Wzm1h4c6' AS wachtwoord, -- is gehashed in php
4					AS vraag, --stad waar gebruiker geboren is
Location			AS antwoordtekst, -- locatie als antwoord
1					AS verkoper,
0					AS beheerder,
0					AS geblokeerd,
0					AS gezien
FROM dbo.Users

-- Compleet --
INSERT INTO dbo.Rubrieken
SELECT ID	AS rubrieknummer,
Name		AS rubrieknaam,
Parent		AS superrubriek,
ID			AS volgnr
FROM dbo.Categorieen

go 
SET IDENTITY_INSERT Voorwerp ON
go
-- alle koersen komen van www.wisselkoers.nl op 23/05/2019 om 11:11
INSERT INTO dbo.Voorwerp (voorwerpnr, titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam, 
land, looptijd, looptijdbegindagtijdstip, verzendkosten, verzendinstructies, verkoper, koper, looptijdeindedagtijdstip, 
veilinggesloten, verkoopprijs, gezien)
SELECT DISTINCT
	ID		AS voorwerpnr,
	Titel	AS titel,
	Beschrijving AS beschrijving,
	Prijs	AS startprijs,
	'Paypal'AS betalingswijze,
	NULL	AS betalingsinstructie,
	Locatie AS plaatsnaam,
Locatie AS land, 
	7		AS looptijd,
	CURRENT_TIMESTAMP AS looptijdbegindagtijdstip,
	NULL	AS verzendkosten,
	NULL	AS verzendinstructies,
	LEFT(Verkoper, 50) AS verkoper,
	NULL	AS koper,
	DATEADD(second, CAST(RAND() * 10 AS INT), DATEADD(day, 7, CURRENT_TIMESTAMP)) AS looptijdeindedagtijdstip, 
	0		AS veilinggesloten,
	NULL	as verkoopprijs,
	0		AS gezien
FROM dbo.Items
WHERE Valuta = 'EUR'

INSERT INTO dbo.Voorwerp (voorwerpnr, titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam, 
land, looptijd, looptijdbegindagtijdstip, verzendkosten, verzendinstructies, verkoper, koper, looptijdeindedagtijdstip, 
veilinggesloten, verkoopprijs, gezien)
SELECT DISTINCT
	ID		AS voorwerpnr,
	Titel	AS titel,
	Beschrijving AS beschrijving,
	(Convert(Decimal(6, 2),(CONVERT(DECIMAL(6, 2), Items.Prijs) * 0.667))) AS startprijs,
	'Paypal'AS betalingswijze,
	NULL	AS betalingsinstructie,
	Locatie AS plaatsnaam,
	Locatie AS land, 
	7		AS looptijd,
	CURRENT_TIMESTAMP AS looptijdbegindagtijdstip,
	NULL	AS verzendkosten,
	NULL	AS verzendinstructies,
	LEFT(Verkoper, 50) AS verkoper,
	NULL	AS koper,
	DATEADD(second, CAST(RAND() * 10 AS INT), DATEADD(day, 7, CURRENT_TIMESTAMP)) AS looptijdeindedagtijdstip, 
	0		AS veilinggesloten,
	NULL	as verkoopprijs,
	0		AS gezien
FROM dbo.Items
WHERE Valuta = 'CAD'


INSERT INTO dbo.Voorwerp (voorwerpnr, titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam, 
land, looptijd, looptijdbegindagtijdstip, verzendkosten, verzendinstructies, verkoper, koper, looptijdeindedagtijdstip, 
veilinggesloten, verkoopprijs, gezien)
SELECT DISTINCT
	ID		AS voorwerpnr,
	Titel	AS titel,
	Beschrijving AS beschrijving,
	Convert(Decimal(6, 2),(CONVERT(DECIMAL(6, 2), Items.Prijs) * 0.898)) 	AS startprijs,
	'Paypal'AS betalingswijze,
	NULL	AS betalingsinstructie,
	Locatie AS plaatsnaam,
	Locatie AS land, 
	7		AS looptijd,
	CURRENT_TIMESTAMP AS looptijdbegindagtijdstip,
	NULL	AS verzendkosten,
	NULL	AS verzendinstructies,
	LEFT(Verkoper, 50) AS verkoper,
	NULL	AS koper,
	DATEADD(second, CAST(RAND() * 10 AS INT), DATEADD(day, 7, CURRENT_TIMESTAMP)) AS looptijdeindedagtijdstip, 
	0		AS veilinggesloten,
	NULL	as verkoopprijs,
	0		AS gezien
FROM dbo.Items
WHERE Valuta = 'USD'

INSERT INTO dbo.Voorwerp (voorwerpnr, titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam, 
land, looptijd, looptijdbegindagtijdstip, verzendkosten, verzendinstructies, verkoper, koper, looptijdeindedagtijdstip, 
veilinggesloten, verkoopprijs, gezien)
SELECT DISTINCT
	ID		AS voorwerpnr,
	Titel	AS titel,
	Beschrijving AS beschrijving,
	Convert(Decimal(6, 2),(CONVERT(DECIMAL(6, 2), Items.Prijs) * 1.134)) AS startprijs,
	'Paypal'AS betalingswijze,
	NULL	AS betalingsinstructie,
	Locatie AS plaatsnaam,
Locatie AS land, 
	7		AS looptijd,
	CURRENT_TIMESTAMP AS looptijdbegindagtijdstip,
	NULL	AS verzendkosten,
	NULL	AS verzendinstructies,
	LEFT(Verkoper, 50) AS verkoper,
	NULL	AS koper,
	DATEADD(second, CAST(RAND() * 10 AS INT), DATEADD(day, 7, CURRENT_TIMESTAMP)) AS looptijdeindedagtijdstip, 
	0		AS veilinggesloten,
	NULL	as verkoopprijs,
	0		AS gezien
FROM dbo.Items
WHERE Valuta = 'GBP'

SET IDENTITY_INSERT Voorwerp OFF

INSERT INTO dbo.Illustratie (voorwerpnr, IllustratieFile)
select DISTINCT
	ItemID as voorwerpnr,
	IllustratieFile as IllustratieFile
FROM dbo.Illustraties

insert into Voorwerpinrubriek (voorwerpnr, rubrieknr)
select distinct
ID as voorwerpnr,
Categorie as rubrieknr
from Items
