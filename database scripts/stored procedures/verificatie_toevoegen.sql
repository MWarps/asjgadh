CREATE PROCEDURE verificatie_toevoegen @gebruiker varchar(50), @type char(4)
AS
BEGIN
DECLARE @code CHAR(6) = CAST(RAND() * 1000000 AS CHAR(6))
DECLARE @eindtijd smalldatetime

IF (@type = 'post') 
	BEGIN
	SET @eindtijd = DATEADD(day, 10, CURRENT_TIMESTAMP)
	END
	else if (@type = 'mail')
	BEGIN
	SET @eindtijd = DATEADD(hour, 4, CURRENT_TIMESTAMP)
	END

insert into Verificatie
values(@gebruiker, @type, @code, @eindtijd);
END 
