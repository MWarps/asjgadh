CREATE PROCEDURE verificatie_geldig
AS 
BEGIN 
DELETE FROM Gebruiker INNER JOIN Verificatie ON Gebruiker.gebruikersnaam = Verificatie.gebruikersnaam WHERE eindtijd > CURRENT_TIMESTAMP AND verifieerd = 0;
DELETE FROM Verificatie WHERE eindtijd > CURRENT_TIMESTAMP;
END