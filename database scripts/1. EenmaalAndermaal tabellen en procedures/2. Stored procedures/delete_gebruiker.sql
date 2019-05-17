CREATE PROCEDURE delete_gebruiker @gebruiker varchar(50)
AS 
BEGIN
		BEGIN TRY
    BEGIN TRANSACTION
	DELETE FROM Bod WHERE gebruikersnaam = @gebruiker
	DELETE FROM Voorwerp WHERE gebruikersnaam = @gebruiker
	DELETE FROM Verkoper WHERE gebruikersnaam = @gebruiker
	DELETE FROM Gebruikerstelefoon WHERE gebruikersnaam = @gebruiker
    DELETE FROM Gebruiker WHERE gebruikersnaam = @gebruiker

    COMMIT TRAN -- Transaction Success!
END TRY
BEGIN CATCH
    IF @@TRANCOUNT > 0
        ROLLBACK TRAN --RollBack in case of Error
END CATCH
END