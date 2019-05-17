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
	