INSERT INTO Gebruiker
VALUES ('MWarps', 'Merlijn', 'Warps', 'testadres', NULL, '1234 AB', 'Nijmegen', 'Nederland','20000101', 'merlijn@warps.nu', 'hashed', 5, 'test antwoord', 0);

INSERT INTO Gebruiker
VALUES ('test2', 'testvoornaam', 'testachternaam', 'testadres', NULL, '1234 AB', 'testplaats', 'testland','20000101', 'test@email.test', 'hashed', 5, 'test antwoord', 0);

insert into dbo.vragen(vraagnr,vraag) 
    values (1,'Wat was de naam van uw eerste huisdier?'), 
           (2,'Welke kleur was uw eerste auto?'), 
           (3,'Wat was de naam van uw eerste school waar uw op zat?'), 
           (4,'In welke stad bent u geboren?'), 
           (5,'Wat is de naam van uw favoriete film?'), 
           (6,'What is uw favoriete kleur'), 
           (7,'In welke straat groeide uw op?') 
; 
