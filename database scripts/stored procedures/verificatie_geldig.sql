CREATE PROCEDURE verificatie_geldig
AS 
BEGIN 
DELETE w,e FROM Gebruiker w INNER JOIN Verificatie e ON Gebruiker.gebruikersnaam = Verificatie.gebruikersnaam WHERE eindtijd > CURRENT_TIMESTAMP AND verifieerd = 0;
DELETE FROM Verificatie WHERE eindtijd > CURRENT_TIMESTAMP;
END