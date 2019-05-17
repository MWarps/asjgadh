--use iproject
go 

insert into dbo.vragen(vraagnr,vraag) 
    values (1,'Wat was de naam van uw eerste huisdier?'), 
           (2,'Welke kleur was uw eerste auto?'), 
           (3,'Wat was de naam van uw eerste school waar uw op zat?'), 
           (4,'In welke stad bent u geboren?'), 
           (5,'Wat is de naam van uw favoriete film?'), 
           (6,'What is uw favoriete kleur'), 
           (7,'In welke straat groeide uw op?') 
; 

insert into Gebruiker
 values 
	('MWarps', 'Merlijn', 'Warps', 'M','testadres', NULL, '1234 AB', 'Nijmegen', 1 ,'20000101', 'merlijn@warps.nu', 'hashed', 5, 'test antwoord', 0, 1, 0);
	
	insert into Gebruiker
 values 
	('sjonnie', 'Merlijn', 'Warps', 'M','testadres', NULL, '1234 AB', 'Nijmegen', 1 ,'20000101', 'roygerrits7@gmail.com', 'hashed', 5, 'test antwoord', 0, 0, 0);
