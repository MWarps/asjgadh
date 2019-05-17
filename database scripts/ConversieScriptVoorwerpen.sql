INSERT INTO EenmaalAndermaal.dbo.Voorwerp (voorwerpnr, titel, beschrijving, startprijs, betalingswijze, plaatsnaam, Land, looptijd, looptijdbegindagtijdstip, verkoper, looptijdeindedagtijdstip, veilinggesloten)
SELECT DISTINCT
	ID AS voorwerpnr,
	Titel AS titel,
	Beschrijving AS beschrijving,
	Prijs AS startprijs,
	'Paypal' AS betalingswijze,
	Locatie AS plaatsnaam,
	(SELECT GBA_CODE FROM EenmaalAndermaal.dbo.Landen WHERE EenmaalAndermaal.dbo.Landen LIKE CONCAT('%', Locatie, '%')) AS land,
	7 AS looptijd,
	GETDATE() AS looptijdbegindagtijdstip,
	Verkoper AS verkoper,
	--DATEADD(day, 7, CURRENT_TIMESTAMP) AS looptijdeindedagtijdstip, -- Moet nog aangepast worden zodat alle items niet tegelijk worden verwijderd
	DATEADD(second, CAST(RAND() * 10 AS INT), DATEADD(day, 7, CURRENT_TIMESTAMP)) AS looptijdeindedagtijdstip, -- CAST(RAND() * 10 AS INT)
	0 AS veilinggesloten
	FROM ebay.dbo.Items

	UPDATE Voorwerp
	SET plaatsnaam = 'Nederland'
	WHERE plaatsnaam like '%,Nederland%'
	