DROP PROCEDURE if exists delete_gebruiker;

go


CREATE PROCEDURE delete_gebruiker @gebruiker varchar(50)
AS 
BEGIN
		BEGIN TRY
    BEGIN TRANSACTION
	DELETE FROM Aanbevolen WHERE gebruikersnaam = @gebruiker
	DELETE FROM Laatstbekeken WHERE gebruikersnaam = @gebruiker
	DELETE FROM Voorwerpinrubriek WHERE voorwerpnr IN (SELECT voorwerpnr FROM Voorwerp WHERE verkoper = @gebruiker)
	DELETE FROM Bod WHERE gebruikersnaam = @gebruiker
	DELETE FROM Illustratie WHERE voorwerpnr IN (SELECT voorwerpnr FROM Voorwerp WHERE verkoper = @gebruiker)
	DELETE FROM Voorwerp WHERE verkoper = @gebruiker
	DELETE FROM Verificatie WHERE email IN (SELECT email FROM Gebruiker WHERE gebruikersnaam = @gebruiker)
	DELETE FROM Gebruikerstelefoon WHERE gebruikersnaam = @gebruiker
	DELETE FROM Verkoper WHERE gebruikersnaam = @gebruiker
    DELETE FROM Gebruiker WHERE gebruikersnaam = @gebruiker
	PRINT 'gebruiker verwijderd'
    COMMIT TRAN -- Transaction Success!
END TRY
BEGIN CATCH
    IF @@TRANCOUNT > 0
	BEGIN
		PRINT 'gebruiker niet verwijderd'
        ROLLBACK TRAN --RollBack in case of Error
	END
END CATCH
END