WITH cte AS
(
SELECT superrubriek, rubrieknummer
FROM dbo.Rubrieken
WHERE superrubriek = 267 --nummer van rubriek waar in gezocht wordt
UNION ALL

SELECT  a.superrubriek, a.rubrieknummer
	FROM dbo.Rubrieken a
	INNER JOIN cte s ON a.superrubriek = s.rubrieknummer
)

SELECT distinct top 20 dbo.Voorwerp.voorwerpnr, dbo.Voorwerp.titel, dbo.Voorwerp.geblokkeerd  --hier aangeven hoeveel waardes gereturned worden
	FROM dbo.Voorwerpinrubriek
	left JOIN dbo.Voorwerp on dbo.Voorwerpinrubriek.voorwerpnr = dbo.Voorwerp.voorwerpnr
	right JOIN cte on dbo.Voorwerpinrubriek.rubrieknr = cte.rubrieknummer;