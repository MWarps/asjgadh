CREATE PROCEDURE telefoon_toevoegen @gebruiker varchar(50), @telefoonnummer VARCHAR(15)
AS 
BEGIN
DECLARE @volgnr INT

SET @volgnr = (SELECT COUNT(volgnr) FROM Gebruikerstelefoon WHERE gebruikersnaam = @gebruiker + 1)

BEGIN TRY
    BEGIN TRANSACTION
	
	INSERT INTO Gebruikerstelefoon
	VALUES(@volgnr, @gebruiker, @telefoonnummer)

    COMMIT TRAN -- Transaction Success!
END TRY
BEGIN CATCH
    IF @@TRANCOUNT > 0
        ROLLBACK TRAN --RollBack in case of Error
END CATCH
END