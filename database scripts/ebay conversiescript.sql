
INSERT INTO EenmaalAndermaal.dbo.Gebruiker
SELECT Username AS gebruikersnaam,
Username AS voornaam, -- is niet bekend bij ebay
Username AS achternaam, -- is niet bekend bij ebay
'X' AS geslacht,
Location AS adresregel1,
Postalcode AS postcode, -- niet overal gestandaardiseerd
Location AS plaatsnaam, -- is vaak het land plaatsnaam is maar bij sommige gebruikers bekend
1 AS land, --country code query
'20000101' AS geboortedatum, -- is niet bekend bij ebay
CONCAT('asjgadh+', Username, '@gmail.com') AS email, -- email naam nog niet final
'$2y$10$Ggqn9ZFypjDNwTi.e0WSj.HRyB5SoycCDtef2AnuCY5y5Wzm1h4c6' as wachtwoord, -- is gehashed in php
4 AS vraag, --stad waar gebruiker geboren is
Location AS antwoordtekst, -- locatie als antwoord
1 AS verkoper, -- 
0 AS beheerder
FROM ebay.dbo.Users
