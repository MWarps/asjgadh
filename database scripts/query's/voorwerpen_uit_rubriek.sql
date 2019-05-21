WITH cte AS
(
SELECT superrubriek, rubrieknummer
FROM dbo.Rubrieken
WHERE superrubriek = 1 --nummer van rubriek waar in gezocht wordt
UNION ALL

SELECT  a.superrubriek, a.rubrieknummer
	FROM dbo.Rubrieken a
	INNER JOIN cte s ON a.superrubriek = s.rubrieknummer
)

SELECT TOP 20 * --hier aangeven hoeveel waardes gereturned worden
	FROM dbo.Voorwerp
	join dbo.Voorwerpinrubriek
	on dbo.Voorwerp.voorwerpnr = dbo.Voorwerpinrubriek.voorwerpnr
	WHERE dbo.Voorwerpinrubriek.rubrieknr IN (SELECT distinct cte.rubrieknummer
													FROM cte)
