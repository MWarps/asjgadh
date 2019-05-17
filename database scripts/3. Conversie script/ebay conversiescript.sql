
INSERT INTO EenmaalAndermaal.dbo.Gebruiker
SELECT DISTINCT LEFT(Username, 50) AS gebruikersnaam,
' ' AS voornaam, -- is niet bekend bij ebay
' ' AS achternaam, -- is niet bekend bij ebay
'X' AS geslacht,
Location AS adresregel1,
'' AS adresregel2, --geeft error als niet genoemd wordt
Postalcode AS postcode, -- niet overal gestandaardiseerd
Left(Location, 28) AS plaatsnaam, -- is vaak het land plaatsnaam is maar bij sommige gebruikers bekend
1 AS land, --country code query
'20000101' AS geboortedatum, -- is niet bekend bij ebay
CONCAT('asjgadh+', Username, '@gmail.com') AS email, -- email naam nog niet final
'$2y$10$Ggqn9ZFypjDNwTi.e0WSj.HRyB5SoycCDtef2AnuCY5y5Wzm1h4c6' as wachtwoord, -- is gehashed in php
4 AS vraag, --stad waar gebruiker geboren is
Location AS antwoordtekst, -- locatie als antwoord
1 AS verkoper,
0 AS beheerder
FROM ebay.dbo.Users

INSERT INTO EenmaalAndermaal.dbo.Rubrieken
SELECT ID AS rubrieknummer,
Name AS rubrieknaam,
Parent AS superrubriek,
ID AS volgnr
FROM ebay.dbo.Categorieen

go 

insert into dbo.Voorwerp (voorwerpnr, titel, beschrijving, startprijs, betalingswijze, plaatsnaam, Land, looptijd, looptijdbegindagtijdstip, verkoper, looptijdeindedagtijdstip, veilinggesloten)
select distinct
	ID as voorwerpnr,
	Titel as titel,
	Beschrijving as beschrijving,
	Prijs as startprijs,
	'Paypal' as betalingswijze,
	Locatie as plaatsnaam,
	select code from dbo.Landen where  as land,
	7 as looptijd,
	GETDATE() as looptijdbegindagtijdstip,
	Verkoper as verkoper,
	DATEADD(day, 7, CURRENT_TIMESTAMP) as looptijdeindedagtijdstip, -- Moet nog aangepast worden zodat alle items niet tegelijk worden verwijderd
	0 as veilinggesloten
	from dbo.Items

	UPDATE Voorwerp
	SET plaatsnaam = 'Nederland'
	WHERE plaatsnaam like '%,Nederland%'
