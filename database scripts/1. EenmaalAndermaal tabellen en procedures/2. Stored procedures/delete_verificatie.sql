CREATE PROCEDURE delete_verificatie @email VARCHAR(254), @type CHAR(5)
AS
BEGIN
DELETE FROM Verificatie WHERE email = @email AND type = @type
END