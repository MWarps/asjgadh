DECLARE @parent INT = 0; -- vul op de plaats van de nul de superrubriek waar je de items uit wil in
WITH cte AS
(
select null superrubriek, @parent rubrieknummer
union
SELECT  a.superrubriek, a.rubrieknummer
	FROM dbo.Rubrieken a
	WHERE a.superrubriek = @parent
	UNION ALL
SELECT a.superrubriek, a.rubrieknummer
	FROM dbo.Rubrieken a JOIN cte c ON a.superrubriek = c.rubrieknummer
												)

SELECT TOP 20 *
	FROM dbo.Voorwerp
	join dbo.Voorwerpinrubriek
	on dbo.Voorwerp.voorwerpnr = dbo.Voorwerpinrubriek.voorwerpnr
	WHERE dbo.Voorwerpinrubriek.rubrieknr IN (SELECT distinct cte.rubrieknummer
													FROM cte)
