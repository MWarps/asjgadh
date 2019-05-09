CREATE PROCEDURE verificatie_geldig
AS 
BEGIN 
DELETE FROM Verificatie WHERE eindtijd > CURRENT_TIMESTAMP ;
END