
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

