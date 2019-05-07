CREATE PROCEDURE delete_verificatie @gebruiker VARCHAR(50), @type CHAR(4)
AS
BEGIN
DECLARE @verifieerd bit = 1
SELECT verifieerd = @verifieerd from Gebruiker where gebruikersnaam = @gebruiker
if(@type = 'mail')
	BEGIN
	if(@verifieerd = 0)
		BEGIN
		DELETE FROM Verificatie WHERE gebruikersnaam = @gebruiker AND type = @type
		DELETE FROM Gebruiker WHERE gebruikersnaam = @gebruiker
		END
	END
	else
	BEGIN
	DELETE FROM Verificatie WHERE gebruikersnaam = @gebruiker AND type = @type
	END
END