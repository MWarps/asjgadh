CREATE PROCEDURE verificatie_toevoegen @mail varchar(254), @type char(4)
AS
BEGIN
DECLARE @code CHAR(6) = CAST(RAND() * 1000000000 AS CHAR(10))
DECLARE @eindtijd smalldatetime

IF (@type = 'brief') 
	BEGIN
	SET @eindtijd = DATEADD(day, 10, CURRENT_TIMESTAMP)
	END
	else if (@type = 'email')
	BEGIN
	SET @eindtijd = DATEADD(hour, 4, CURRENT_TIMESTAMP)
	END
	else if (@type = 'reset')
	BEGIN
	SET @eindtijd = DATEADD(hour, 4, CURRENT_TIMESTAMP)
	END

insert into Verificatie
values(@mail, @type, @code, @eindtijd);
END 
