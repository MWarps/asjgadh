DROP PROCEDURE if exists verificatie_toevoegen;

go

CREATE PROCEDURE verificatie_toevoegen @mail varchar(254), @type char(5)
AS
BEGIN
DECLARE @code CHAR(8) = CAST(RAND() * 1000000 AS INT)
DECLARE @eindtijd smalldatetime
DECLARE @verzonden BIT

IF (@type = 'brief') 
	BEGIN
	SET @eindtijd = DATEADD(day, 10, CURRENT_TIMESTAMP)
	END
	else if (@type = 'email')
	BEGIN
	SET @eindtijd = DATEADD(hour, 4, CURRENT_TIMESTAMP)
	SET @verzonden = 1
	END
	else if (@type = 'reset')
	BEGIN
	SET @eindtijd = DATEADD(hour, 4, CURRENT_TIMESTAMP)
	END

insert into Verificatie
values(@mail, @type, @code, @eindtijd, @verzonden);
END 
