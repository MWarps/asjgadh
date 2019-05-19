delete from dbo.Gebruiker
delete from dbo.Rubrieken
delete from dbo.Voorwerp

INSERT INTO dbo.Gebruiker (gebruikersnaam, voornaam, achternaam, geslacht, adresregel1, adresregel2, postcode, plaatsnaam, 
land, geboortedatum, email, wachtwoord, vraag, antwoordtekst, verkoper, beheerder, geblokeerd)
SELECT DISTINCT 
LEFT(Username, 50)	AS gebruikersnaam,
' '					AS voornaam, -- is niet bekend bij ebay
' '					AS achternaam, -- is niet bekend bij ebay
'X'					AS geslacht,
Location			AS adresregel1, 
NULL				AS adresregel2,
Postalcode			AS postcode, -- niet overal gestandaardiseerd
Left(Location, 28)	AS plaatsnaam, -- is vaak het land plaatsnaam is maar bij sommige gebruikers bekend
6030				AS land, --country code query !!!!!!
'20000101'			AS geboortedatum, -- is niet bekend bij ebay
CONCAT('asjgadh+', Username, '@gmail.com') AS email, -- email naam nog niet final
'$2y$10$Ggqn9ZFypjDNwTi.e0WSj.HRyB5SoycCDtef2AnuCY5y5Wzm1h4c6' AS wachtwoord, -- is gehashed in php
4					AS vraag, --stad waar gebruiker geboren is
Location			AS antwoordtekst, -- locatie als antwoord
1					AS verkoper,
0					AS beheerder,
0					AS geblokeerd
FROM dbo.Users

-- Compleet --
INSERT INTO dbo.Rubrieken
SELECT ID	AS rubrieknummer,
Name		AS rubrieknaam,
Parent		AS superrubriek,
ID			AS volgnr
FROM dbo.Categorieen

go 

INSERT INTO dbo.Voorwerp (voorwerpnr, titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam, 
land, looptijd, looptijdbegindagtijdstip, verzendkosten, verzendinstructies, verkoper, koper, looptijdeindedagtijdstip, 
veilinggesloten, verkoopprijs)
SELECT DISTINCT
	ID AS voorwerpnr,
	Titel AS titel,
	Beschrijving AS beschrijving,
	Prijs AS startprijs,
	'Paypal' AS betalingswijze,
	NULL as betalingsinstructie,
	Locatie AS plaatsnaam,
	6030 AS land, -- lukt niet vanwege GBA_CODE !!!!
	7 AS looptijd,
	CURRENT_TIMESTAMP AS looptijdbegindagtijdstip,
	NULL as verzendkosten,
	NULL as verzendinstructies,
	LEFT(Verkoper, 50) AS verkoper,
	NULL as koper,
	DATEADD(second, CAST(RAND() * 10 AS INT), DATEADD(day, 7, CURRENT_TIMESTAMP)) AS looptijdeindedagtijdstip, 
	0 AS veilinggesloten,
	NULL as verkoopprijs
	FROM dbo.Items