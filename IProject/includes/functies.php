<?php
include 'email.php';
include 'email2.php';
include 'emailBericht.php';
include 'emailVerkocht.php';
include 'emailGekocht.php';
include 'emailVerwijderdVerkoper.php';
include 'emailVerwijderdHoogstebod.php';
include 'brief.php';

function BodVerhoging($Euro){
    $Verhoging;
    switch ($Euro) {
        case ($Euro <50) :
            $Verhoging = 0.50;
            break;
        case ($Euro >=50 && $Euro <500):
            $Verhoging = 1;
            break;
        case ($Euro >=500 && $Euro <1000) :
            $Verhoging = 5;
            break;
        case ($Euro >=1000 && $Euro <5000):
            $Verhoging = 10;
            break;
        case ($Euro >=5000) :
            $Verhoging = 50;                    
        default:
            break;
    }
    return $Verhoging;
}

function HaalVoorwerpOp($gebruikersnaam){


}

function gebruikerBekeekVoorwerp($gebruikersnaam, $voorwerpnr) {
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
                                    INSERT INTO Laatstbekeken (gebruikersnaam, voorwerpnr, datumtijd)
                                    VALUES (:gebruikersnaam, :voorwerpnr , CURRENT_TIMESTAMP )                                                                  
                                    ");
        $sqlSelect->execute(
            array(
                ':voorwerpnr' => $voorwerpnr,
                ':gebruikersnaam' => $gebruikersnaam
            ));
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function gebruikerAanbevolen($gebruikersnaam, $voorwerpnr) {
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
        INSERT INTO Aanbevolen (gebruikersnaam, rubrieknr, datumtijd)
        VALUES (:gebruikersnaam, (select rubrieknr from Voorwerpinrubriek where voorwerpnr = :voorwerpnr), CURRENT_TIMESTAMP )                                                                    
                                    ");
        $sqlSelect->execute(
            array(
                ':voorwerpnr' => $voorwerpnr,
                ':gebruikersnaam' => $gebruikersnaam
            ));
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function VoegVoorwerpToeAanIllustratie($voorwerpnr, $illustratieFile){
    try {
        // SQL insert statement
        require('core/dbconnection.php');
        $sqlInsert = $dbh->prepare("INSERT INTO Illustratie (voorwerpnr, illustratieFile )
  values (
    :voorwerpnr, :IllustratieFile)");

        $sqlInsert->execute(
            array(
                ':voorwerpnr' => $voorwerpnr,
                ':IllustratieFile' => $illustratieFile

            ));
    }
    catch (PDOexception $e) {
        echo "er ging iets mis insert {$e->getMessage()}";
    }

}

function VoegVoorwerpAanRubriekToe($voorwerpnr, $rubriek){

    try {
        // SQL insert statement
        require('core/dbconnection.php');
        $sqlInsert = $dbh->prepare("INSERT INTO Voorwerpinrubriek (rubrieknr, voorwerpnr)
    values (
      :rubrieknr, :voorwerpnr)");

        $sqlInsert->execute(
            array(
                ':rubrieknr' => $rubriek,
                ':voorwerpnr' => $voorwerpnr

            ));
    }
    catch (PDOexception $e) {
        echo "er ging iets mis insert {$e->getMessage()}";
    }
}

function VoegVoorwerpToe($input){
    try {
        // SQL insert statement
        require('core/dbconnection.php');
        $sqlInsert = $dbh->prepare("INSERT INTO Voorwerp (
     titel, beschrijving, startprijs, betalingswijze, betalingsinstructie,
     plaatsnaam, land, looptijd, verzendkosten, verzendinstructies, verkoper, 
     looptijdeindedagtijdstip
     )
    values (
      :titel, :beschrijving, :startprijs, :betalingswijze, :betalingsinstructie,
      :plaatsnaam, :land, :looptijd, :verzendkosten, :verzendinstructies, :verkoper, 
      DATEADD(day, 7, CURRENT_TIMESTAMP)) ");

        $sqlInsert->execute(
            array(
                ':titel' => $input['0'],
                ':beschrijving' => $input['1'],
                ':startprijs' => $input['2'],
                ':betalingswijze' => $input['3'],
                ':betalingsinstructie' => $input['4'],
                ':plaatsnaam' => $input['5'],
                ':land' => $input['6'],
                ':looptijd' => $input['7'],
                ':verzendkosten' => $input['8'],
                ':verzendinstructies' => $input['9'],
                ':verkoper' => $input['10']

            ));
    }
    catch (PDOexception $e) {
        echo "er ging iets mis insert {$e->getMessage()}";
    }

    try {
        // SQL insert statement
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("SELECT voorwerpnr from Voorwerp where verkoper = :verkoper
      order by looptijdbegindagtijdstip desc");

        $sqlSelect->execute(
            array(        
                ':verkoper' => $input['10']  
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);   
        return $records; 
    }

    catch (PDOexception $e) {
        echo "er ging iets mis insert {$e->getMessage()}";
    }

}  


function getPopulairsteArtikelen() {
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("SELECT TOP 9 * FROM Voorwerp ORDER BY gezien DESC");
        $sqlSelect->execute();
        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOexception $e) {
        echo "er ging iets mis errorteset: {$e->getMessage()}";
    }


    foreach ($records as $rij) {
        $details = DetailAdvertentie($rij['voorwerpnr']);
        $locatie = '../pics/';
        
        $hoogstebieder = zijnErBiedingen($details['voorwerpnr']);
        $hoogstbieder = $hoogstebieder['euro'];
        
        if(!empty($hoogstbieder)){
          $details['startprijs'] = $hoogstbieder;
        }  
        
        if(substr($details['illustratieFile'] , 0 ,2 ) == 'ea'){
            $locatie = 'upload/';
        }        

        if(strlen($details['titel']) >= 40){
            $details['titel'] = substr($details['titel'],0,40);
            $details['titel'] .= '...';
        }
        echo '
        <div class="col-md-4 py-3">
          <div class="card" style="width: 18rem;">
            <div class="card-img-boven">
              <img src="'.$locatie.$details['illustratieFile'].'" alt="Foto bestaat niet">
            </div>  
          <h5 class="card-header"><a href="advertentie.php?id='.$details['voorwerpnr'].'">'.$details['titel'].'</a></h5>
            <div class="card-body">
              <h4 class="card-text">€ '.number_format($details['startprijs'], 2, ',', '.').'</h4>
              <p class="card-text"><a href="#">'.$details['verkoper'].'</a><br>
              '.$details['land'].', '.$details['plaatsnaam'].'</p>
              <a href="advertentie.php?id='.$details['voorwerpnr'].'" class="btn btn-block btn-primary">Ga naar artikel</a>
            </div>
        </div>
        </div>';
    }}


function getProductenUitRubriek2($rubriek, $aantal) {

    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("WITH cte AS
        (
        SELECT superrubriek, rubrieknummer
        FROM dbo.Rubrieken
        WHERE rubrieknummer = :rubriek
        UNION ALL

        SELECT  a.superrubriek, a.rubrieknummer
        	FROM dbo.Rubrieken a
        	INNER JOIN cte s ON a.superrubriek = s.rubrieknummer
        )
        SELECT distinct top 21 * 
        	FROM dbo.Voorwerpinrubriek
        	JOIN dbo.Voorwerp on dbo.Voorwerpinrubriek.voorwerpnr = dbo.Voorwerp.voorwerpnr
        	JOIN cte on dbo.Voorwerpinrubriek.rubrieknr = cte.rubrieknummer;");

        $sqlSelect->execute(
            array(
                ':rubriek' => $rubriek,
                //  ':aantal' => $aantal
            ));

        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);

        return $records;
    }
    catch (PDOexception $e) {
        echo "er ging iets mis error2: {$e->getMessage()}";
    }
}

function getProductenUitRubriek($rubriek, $aantal) {

    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("WITH cte AS
        (
        SELECT superrubriek, rubrieknummer
        FROM dbo.Rubrieken
        WHERE superrubriek = :rubriek
        UNION ALL

        SELECT  a.superrubriek, a.rubrieknummer
        	FROM dbo.Rubrieken a
        	INNER JOIN cte s ON a.superrubriek = s.rubrieknummer
        )
        SELECT distinct top 21 * 
        	FROM dbo.Voorwerpinrubriek
        	JOIN dbo.Voorwerp on dbo.Voorwerpinrubriek.voorwerpnr = dbo.Voorwerp.voorwerpnr
        	JOIN cte on dbo.Voorwerpinrubriek.rubrieknr = cte.rubrieknummer;");

        $sqlSelect->execute(
            array(
                ':rubriek' => $rubriek,
                //  ':aantal' => $aantal
            ));

        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);

        return $records;
    }
    catch (PDOexception $e) {
        echo "er ging iets mis error2: {$e->getMessage()}";
    }
}



function getLaatstBekeken($gebruiker) {
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("SELECT TOP 3 * FROM LaatstBekeken
      WHERE gebruikersnaam = :gebruikersnaam
	  ORDER BY datumtijd DESC");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruiker
            ));
        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);      
    }      
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
    if(empty($records)){
        echo '<div class="alert alert-success" role="alert">
              U heeft nog geen laatsbekeken voorwerpen!
            </div>';
    }
    else{
        foreach ($records as $rij) {
            $details = DetailAdvertentie($rij['voorwerpnr']);
            $locatie = '../pics/';

            $hoogstebieder = zijnErBiedingen($details['voorwerpnr']);
            $hoogstbieder = $hoogstebieder['euro'];
            
            if(!empty($hoogstbieder)){
              $details['startprijs'] = $hoogstbieder;
            }  
            if(substr($details['illustratieFile'] , 0 ,2 ) == 'ea'){
                $locatie = 'upload/';
            } 

            if(strlen($details['titel']) >= 40){
                $details['titel'] = substr($details['titel'],0,40);
                $details['titel'] .= '...';
            }
            echo '
        <div class="col-md-4 py-3">
        <div class="card" style="width: 18rem;">
        <div class="card-img-boven">
          <img src="'.$locatie.$details['illustratieFile'].'" alt="Foto bestaat niet">
        </div> 
          <h5 class="card-header"><a href="advertentie.php?id='.$details['voorwerpnr'].'">'.$details['titel'].'</a></h5>
            <div class="card-body">
              <h4 class="card-text">€ '.number_format($details['startprijs'], 2, ',', '.').'</h4>
              <p class="card-text"><a href="#">'.$details['verkoper'].'</a><br>
              '.$details['land'].', '.$details['plaatsnaam'].'</p>
              <a href="advertentie.php?id='.$details['voorwerpnr'].'" class="btn btn-block btn-primary">Ga naar artikel</a>
            </div>
        </div>
        </div>';
        }}
}

function getAanbevolen($gebruiker) {
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("SELECT * FROM Aanbevolen
                                    WHERE gebruikersnaam = :gebruikersnaam
	                                   ORDER BY datumtijd DESC");
        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruiker
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);      
    }      
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
    $records = getProductenUitRubriek2($records['rubrieknr'], 3) ;

    if(empty($records)){
        echo '<div class="alert alert-success" role="alert">
              U heeft nog geen aanbevolen voorwerpen!
            </div>';
    }
    else{
        for ($teller = 0; $teller < 3; $teller++) {
          
            $details = DetailAdvertentie($records[$teller]['voorwerpnr']);
            $locatie = '../pics/';
            
            $hoogstebieder = zijnErBiedingen($details['voorwerpnr']);
            $hoogstbieder = $hoogstebieder['euro'];
            
            if(!empty($hoogstbieder)){
              $details['startprijs'] = $hoogstbieder;
            } 
            
            if(substr($details['illustratieFile'] , 0 ,2 ) == 'ea'){
                $locatie = 'upload/';
            } 
            if(strlen($details['titel']) >= 40){
                $details['titel'] = substr($details['titel'],0,40);
                $details['titel'] .= '...';
            }
            echo '
        <div class="col-md-4 py-3">
        <div class="card" style="width: 18rem;">
        <div class="card-img-boven">
          <img src="'.$locatie.$details['illustratieFile'].'" alt="Foto bestaat niet">
        </div> 
          <h5 class="card-header"><a href="advertentie.php?id='.$details['voorwerpnr'].'">'.$details['titel'].'</a></h5>
            <div class="card-body">
              <h4 class="card-text">€ '.number_format($details['startprijs'], 2, ',', '.').'</h4>
              <p class="card-text"><a href="#">'.$details['verkoper'].'</a><br>
              '.$details['land'].', '.$details['plaatsnaam'].'</p>
              <a href="advertentie.php?id='.$details['voorwerpnr'].'" class="btn btn-block btn-primary">Ga naar artikel</a>
            </div>
        </div>
        </div>';
        }}
}

function HaalIllustratiesOp($voorwerpnr){

    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select illustratieFile from Voorwerp, Illustratie
      where Voorwerp.voorwerpnr = Illustratie.voorwerpnr
      AND Voorwerp.voorwerpnr = :voorwerpnr");

        $sqlSelect->execute(
            array(
                ':voorwerpnr' => $voorwerpnr
            ));

        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);  
        return $records;    


    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    } 
}

function zijnErBiedingen($voorwerpnr){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select * from bod where voorwerpnr = :voorwerpnr order by convert(decimal(9,2), euro) desc");

        $sqlSelect->execute(
            array(
                ':voorwerpnr' => $voorwerpnr
            ));

        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);  
        return $records;     

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }  
}

function VoorwerpGezien($voorwerpnr) {
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare(" UPDATE Voorwerp
      Set gezien = gezien + 1
      Where voorwerpnr = :voorwerpnr");

        $sqlSelect->execute(
            array(
                ':voorwerpnr' => $voorwerpnr
            ));

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function updateBieden($bod, $gebruikersnaam, $voorwerpnr){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("INSERT INTO bod (euro, gebruikersnaam, voorwerpnr)
      values (:bod, :gebruikersnaam, :voorwerpnr)");

        $sqlSelect->execute(
            array(
                ':bod' => $bod,
                ':gebruikersnaam' => $gebruikersnaam,
                ':voorwerpnr' => $voorwerpnr
            ));

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}

function Biedingen($voorwerpnr){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select top 5 * from Bod where voorwerpnr = :voorwerpnr order by convert(decimal(9,2), euro) desc");

        $sqlSelect->execute(
            array(
                ':voorwerpnr' => $voorwerpnr
            ));
        $rows = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
        //print_r($rows);

        foreach ($rows as $rij)
        {
            echo '<li class="list-group-item">€'.number_format($rij['euro'], 2, ',', '.').' - '.$rij['gebruikersnaam'].' - '.date("d.m.Y H:i", strtotime($rij['datumentijd'])).'</li>';                
        }

    } catch (PDOexception $e) {
        echo "er ging iets mis errorbiedingen: {$e->getMessage()}";
    }

}
function DetailAdvertentie($id)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select *, illustratieFile from Voorwerp, Illustratie
        where Voorwerp.voorwerpnr = Illustratie.voorwerpnr
        AND Voorwerp.voorwerpnr = :id
        AND Voorwerp.veilinggesloten = 0");

        $sqlSelect->execute(
            array(
                ':id' => $id              
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        return $records;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}

function DetailAdvertentieMijnAdvertenties($id)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select *, illustratieFile from Voorwerp, Illustratie
        where Voorwerp.voorwerpnr = Illustratie.voorwerpnr
        AND Voorwerp.voorwerpnr = :id
        ");

        $sqlSelect->execute(
            array(
                ':id' => $id              
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        return $records;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}

/* advertentie ophalen */
function haalAdvertentieOp($rubriek){
    try {
        $producten = getProductenUitRubriek($rubriek, 20); 

        if(empty($producten)){
            $producten = getProductenUitRubriek2($rubriek, 20);                      
        }

        foreach ($producten as $rij) {
            $details = DetailAdvertentie($rij['voorwerpnr']);
            $locatie = '../pics/';
            
            $hoogstebieder = zijnErBiedingen($details['voorwerpnr']);
            $hoogstbieder = $hoogstebieder['euro'];
            
            if(!empty($hoogstbieder)){
              $details['startprijs'] = $hoogstbieder;
            }
            
            if(substr($details['illustratieFile'] , 0 ,2 ) == 'ea'){
                $locatie = 'upload/';
            } 
            if(strlen($rij['titel']) >= 40){
                $rij['titel'] = substr($rij['titel'],0,40);
                $rij['titel'] .= '...';
            }
            echo '
            <div class="col-md-4 pb-3">
            <div class="card" style="width: 18rem;">
            <div class="card-img-boven">
              <img src="'.$locatie.$details['illustratieFile'].'" alt="Foto bestaat niet">
            </div> 
              <h5 class="card-header"><a href="advertentie.php?id='.$details['voorwerpnr'].'">'.$details['titel'].'</a></h5>
                <div class="card-body">
                  <h4 class="card-text">€ '.number_format($details['startprijs'], 2, ',', '.').'</h4>
                  <p class="card-text"><a href="#">'.$details['verkoper'].'</a><br>
                  '.$details['land'].', '.$details['plaatsnaam'].'</p>
                  <a href="advertentie.php?id='.$details['voorwerpnr'].'" class="btn btn-block btn-primary">Ga naar artikel</a>
                </div>
            </div>
            </div>';

        }

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}



/* deleting verificatie code*/
function haalCodeOp($id){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select email, type from Verificatie where verificatiecode = :id");

        $sqlSelect->execute(
            array(
                ':id' => $id              
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        return $records;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}
/* update gebruiker naar geverifieerd */
function updateGebruikerVerificatie($input){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("UPDATE Gebruiker SET verifieerd = 1
        WHERE gebruikersnaam = :gebruikersnaam");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $input['0']
            ));

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}

/* deleting verificatie code*/
function deleteVerificatieRij($email, $type){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("delete from Verificatie where email = :email and type = :type");

        $sqlSelect->execute(
            array(
                ':email' => $email,
                ':type' => $type
            ));

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}

/* Ophalen van verficatie code */
function HaalGebruikerOp($gebruikersnaam){

    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select * from Gebruiker
      where gebruikersnaam = :gebruikersnaam");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruikersnaam
            ));

        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        return $records;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

/* Ophalen van verficatie code */
function HaalVerficatiecodeOp($email, $type){

    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select verificatiecode, eindtijd from Verificatie where email = :email
      And type = :type ");

        $sqlSelect->execute(
            array(
                ':email' => $email,
                ':type' => $type
            ));

        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        return $records;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

/* Verificate code en eindtijd aanmaken*/
function VerificatieCodeProcedure($email, $type){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("EXEC verificatie_toevoegen @mail = :email, @type = :type");

        $sqlSelect->execute(
            array(
                ':email' => $email,
                ':type' => $type
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function insertVerkoper($input){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("insert into Verkoper (gebruikersnaam, bank, bankrekeningnummer, creditcard)
                                    values (:gebruikersnaam, :bank, :bankrekeningnr, :creditcard)");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $input['0'],
                ':bank' => $input['1'],
                ':bankrekeningnr' => $input['2'],
                ':creditcard' => $input['3']
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis insert: {$e->getMessage()}";
    }
}

/* Voeg gebruiker toe aan database */
function InsertGebruiker($input){
    $hashedWachtwoord = password_hash($input['4'], PASSWORD_DEFAULT);
    try {
        // SQL insert statement
        require('core/dbconnection.php');
        $sqlInsert = $dbh->prepare("INSERT INTO Gebruiker (
       gebruikersnaam, voornaam, achternaam, geslacht, adresregel1, adresregel2,
       postcode, plaatsnaam, land, geboortedatum, email,
       wachtwoord, vraag, antwoordtekst, verkoper)
      values (
        :rGebruikersnaam, :rVoornaam, :rAchternaam, :rGeslacht, :rAdresregel1, :rAdresregel2,
        :rPostcode, :rPlaatsnaam, :rLand, :rGeboortedatum, :rEmail,
        :rWachtwoord, :rVraag, :rAntwoordtekst, :rVerkoper)");

        $sqlInsert->execute(
            array(
                ':rGebruikersnaam' => $input['0'],
                ':rVoornaam' => $input['1'],
                ':rAchternaam' => $input['2'],
                ':rGeslacht' => $input['3'],
                ':rAdresregel1' => $input['5'],
                ':rAdresregel2' => $input['6'],
                ':rPostcode' => $input['7'],
                ':rPlaatsnaam' => $input['8'],
                ':rLand' => $input['9'],
                ':rGeboortedatum' => $input['10'],
                ':rEmail' => $input['11'],
                ':rWachtwoord' => $hashedWachtwoord,
                ':rVraag' => $input['12'],
                ':rAntwoordtekst' => $input['13'],
                ':rVerkoper' => $input['14'],

            ));
    }
    catch (PDOexception $e) {
        echo "er ging iets mis insert {$e->getMessage()}";
    }
}

/* Is er al een gebruiker aangemeld met hetzelfde gebruikersnaam */
function bestaatGebruikersnaam($gebruikersnaam)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select gebruikersnaam from Gebruiker where gebruikersnaam=:gebruikersnaam");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruikersnaam
            )
        );
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;

    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

/* Is er al een gebruiker aangemeld met hetzelfde emailadres */
function bestaatValidatie($email, $type)
{
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select email from Verificatie where email =:email AND type = :type");

        $sqlSelect->execute(
            array(
                ':email' => $email,
                ':type' => $type
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;

    }
    catch (PDOexception $e) {
        echo "er ging iets mis error19: {$e->getMessage()}";
    }
}

/* Is er al een gebruiker aangemeld met hetzelfde emailadres */
function bestaatEmailadres($email)
{
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select email from Gebruiker where email=:email");

        $sqlSelect->execute(
            array(
                ':email' => $email,
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;

    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

/*registeren vragen ophalen */
function resetVragen()
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->query("select vraagnr, vraag from Vragen");

        echo '<label for="inputGeheimeVraag">Geheime Vraag</label>';
        echo '<select name="rGeheimV" class="form-control" id="inputGeheimeVraag">'; // Open your drop down box

        // Loop through the query results, outputing the options one by one
        while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="'.$row['vraagnr'].'">'.$row['vraagnr'].'.&nbsp'.$row['vraag'].'</option>';
        }
        echo '</select>';// Close your drop down box

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function vragenOphalen() { // haalt alleen de veiligheidsvragen op
    try {
        require('core/dbconnection.php');
        $sqlvragenOphalen = $dbh -> prepare ("SELECT vraagnr, vraag FROM vragen");
        $sqlvragenOphalen -> execute();

        while ($info = $sqlvragenOphalen-> fetch(PDO::FETCH_ASSOC)){
            //var_dump($info);
            echo '<option value="'.$info['vraagnr'].'">'.$info['vraagnr'].'.&nbsp'.$info['vraag'].'</option>';
        }
    } catch (PDOexception $e) {
        echo 'error: vragen niet opgehaald';
    }// einde catch exeption $e
}// einde functie vragenOphalen

/* haal landen op */
function landen()
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh-> prepare ("select NAAM_LAND from Landen");
        $sqlSelect  -> execute();

        echo '<label for="inputLanden">Land</label>';
        echo '<select name="rLand" class="form-control" id="inputLanden">';
        // Open your drop down box

        // Loop through the query results, outputing the options one by one
        echo '<option value="Nederland" selected>Nederland</option>';
        while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {

            echo '<option value="'.$row['NAAM_LAND'].'">'.$row['NAAM_LAND'].'</option>';
        }
        echo '</select>';// Close your drop down box
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function StuurWachtwoordResetMailEmail($Email, $Code){


    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "no-reply@iconcepts.nl";
    $to = $Email;
    $subject = "Wachtwoord reset EenmaalAndermaal";
    $message = email2($Code);

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From:" .$from;

    mail($to,$subject,$message, $headers);

}

function StuurRegistreerEmail($Email, $Code){

    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "no-reply@iconcepts.nl";
    $to = $Email;
    $subject = "Validatie link account registreren";
    $message = email($Code);

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From:" .$from;

    mail($to,$subject,$message, $headers);

}

function verificatiesVinden(){
    $teller = 0;
    //echo 'verificaties gevonden';
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("SELECT Gebruiker.voornaam, Gebruiker.achternaam, Gebruiker.email, Gebruiker.geslacht, Gebruiker.adresregel1, Gebruiker.adresregel2, Gebruiker.postcode, Gebruiker.plaatsnaam, Gebruiker.land, Verificatie.verificatiecode, 
        Verificatie.eindtijd FROM Gebruiker INNER JOIN Verificatie ON Gebruiker.email = Verificatie.email WHERE type = 'brief' AND verzonden = 0
        ");

        $sqlSelect->execute();

        $verkopers = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($verkopers);

        foreach ( $verkopers as $verkoper ){
            $teller ++;
            $resultaat = Brief($verkoper);

            //var_dump($resultaat);

            echo '<tr>
                    <th scope="row">'.$teller.'</th>
                    <td>'.$resultaat['adress'].'</td>
                    <td>'.$resultaat['brief'].'</td>
                    <td>'.$resultaat['email'].'</td>                    
                    <td><a class="btn btn-primary" href="verkoperVerificatieBrief.php?email='.$resultaat['email'].'" role="button">verzonden</a></td>';
            echo ' </tr>';
        }

    } catch (PDOexception $e) {
        // echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function verificatieVerzonden($email) {
    $email = fixEmail($email);
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("UPDATE Verificatie SET verzonden = 1 WHERE email = :email");

        //echo 'verificatie verzonden '.$email;

        $sqlSelect->execute(
            array(
                ':email' => $email
            ));
    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function fixEmail($email) {
    $email = str_replace(" ","+",$email);

    return $email;
}


function geslacht()
{

    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh-> prepare("select geslacht from Geslacht");
        $sqlSelect -> execute();
        echo '<label for="inputGeslacht">Geslacht</label>';
        echo '<select name="rGeslacht" class="form-control" id="inputGeslacht" required>';
        // Open your drop down box

        // Loop through the query results, outputing the options one by one
        while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="'.$row['geslacht'].'">'.$row['geslacht'].'</option>';
        }
        echo '</select>';// Close your drop down box

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}

/* stuur reset email naar gebruiker */
function emailResetWachtwoord($gebruikersnaam)
{
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select email, voornaam from Gebruiker where gebruikersnaam = :gebruikersnaam");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruikersnaam,
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );
        $from = "no-reply@iconcepts.nl";
        $to = $records['email'];
        $subject = "Validatie code account registreren";
        $message = '<h1> Hallo '.$records['voornaam'].'</h1>,
                  <br>
                  <br>
                  Bedankt voor het registreren. Hieronder staat de code die ingevoerd
                  moet worden om het registeren te voltooien:
                  <br>
                  <h1>'.rand(1000,9999).'
                  <br>
                  Als u dit niet bent, wijzig dan uw wachtwoord
                  en overweeg ook om uw e-mailwachtwoord te wijzigen om uw
                  accountbeveiliging te garanderen.';
        $headers = "From:" .$from;
        mail($to,$subject,$message, $headers);


    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

/* Reseten van wachtwoord */
function veranderWachtwoord($email,$wachtwoord)
{
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("update Gebruiker set wachtwoord = :wachtwoord
                                  where email = :email");

        $sqlSelect->execute(
            array(
                ':wachtwoord' => $wachtwoord,
                ':email' => $email,
            ));
    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function controleVraag($vraag){
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select gebruiker.vraag from Gebruiker join vragen
        on gebruiker.vraag = vragen.vraagnr where gebruiker.email=:email");

        $sqlSelect->execute(
            array(
                ':email' => $email,
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;

    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function stuurbericht($titel, $bericht, $Verzender, $Ontvanger){

    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "no-reply@iconcepts.nl";
    $to = $Ontvanger['email'];
    $subject = "$titel";
    $message = emailBericht($bericht, $Verzender, $Ontvanger);

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From:" .$from;
    mail($to,$subject,$message, $headers);

}

function statusOpValidatieZetten($gebruikersnaam){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("UPDATE Verkoper Set gevalideerd = 1 WHERE gebruikersnaam = :gebruikersnaam");

        $sqlSelect->execute(
            array (
                ':gebruikersnaam' => $gebruikersnaam,
            ));

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}

function gegevensIngevuld($gebruikersnaam){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("SELECT * FROM Verkoper where gebruikersnaam = :gebruikersnaam");

        $sqlSelect->execute(
            array (
                ':gebruikersnaam' => $gebruikersnaam,
            ));

        $verkoperVerificatie = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
        return $verkoperVerificatie;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }

}

function setupCatogorienVeilen(){
    $_SESSION['catogorieVeilen'] = array("Home"=>"-1");
    // print_r ( $_SESSION['catogorie']); test om de array de var_dumpen
}

function setupCatogorien(){
    $_SESSION['catogorie'] = array("Home"=>"-1");
    // print_r ( $_SESSION['catogorie']); test om de array de var_dumpen
}

function catogorieToevoeging (){
    //    $lengte =  sizeof($_SESSION['catogorie']);
    //    echo $lengte ; echo '<br>';
    //    $lengte ++;
    $array2 = array( $_GET['naam'] =>$_GET['id'] );
    //    if ($id = (end($_SESSION['catogorie']) ) != $_GET['id']){
    //        foreach($_SESSION['catogorie'] as $level => $id){
    //            //$array1 = array ( $_SESSION['catogorie']);
    //            $array1 = array ( $level => $id );
    //        }
    //        print_r($array1);
    //        echo '<br>';
    //        print_r($array2); 
    //       echo '<br>';   
    $_SESSION['catogorie'] = $_SESSION['catogorie']  + $array2; 
}// einde functie

function catogorieSoort($pagina) {
    $teller =0;
    $titel;
    foreach($_SESSION['catogorie'] as $level => $id){
        if ($teller ==0){
            if ($id == -1){
                $titel = "Hoofdmenu" ;        
            }else {
                $titel = $level;
            }
            echo '<li class="breadcrumb-item"><a href="'.$pagina.'?id='.$id.'&naam='.$level.' " >'.$titel.'</a></li>';
            $teller++;
        }
    }       
}

function HaalRubriekNaamOp($id)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh-> prepare ("select rubrieknaam from Rubrieken where rubrieknummer = :id");
        $sqlSelect  -> execute(
            array(
                ':id' =>  $id
            ));

        $row = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $row;  

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
} 

function HaalRubriekop($id)
{
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh-> prepare ("select * from Rubrieken where superrubriek = :id");
        $sqlSelect  -> execute(
            array(
                ':id' =>  $id
            ));

        // Loop through the query results, outputing the options one by one    
        while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
            echo '<a class="dropdown-item" href="catalogus.php?id='.$row['rubrieknummer'].'">'.$row['rubrieknaam'].'</a>';
        }      
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
} 

function DirectorieVindenVeilen(){

    $id = (end($_SESSION['catogorie']) );
    $teller = 0;
    try {
        require('core/dbconnection.php');
        $catogorien = $dbh->prepare("select * from Rubrieken where superrubriek = :id ");
        $catogorien -> execute(
            array(
                ':id' =>  $id,
            )
        );

        $print = $catogorien->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $print as $Name => $id){ 
            echo '<a class="btn btn-outline-dark"  
                  href="veilen.php?id='.$print[$teller]['rubrieknummer'].'&naam='.$print[$teller]['rubrieknaam'].'" 
                  role="button">'.$print[$teller]['rubrieknaam'].'</a>';        
            $teller++ ;
        }

        if(empty($print)){
            $terug = $dbh -> prepare("select * from Rubrieken where rubrieknummer = :id");
            $terug -> execute(
                array(
                    ':id' => $id,));

            $resultaat = $terug->fetchAll(PDO::FETCH_ASSOC);
            //$_SESSION['rubriek'] = true;     
            echo  '<p class="btn" >Uw gekozen rubriek is: <strong>'.$resultaat[0]['rubrieknaam'].'<br></strong>
                   <a class="btn btn-lg bg-flame btn-block mt-1" href="veilen.php?id='.$resultaat[0]['superrubriek'].'&naam='.$resultaat[0]['rubrieknaam'].'">Vorige</a>
                   <a class="btn btn-lg bg-flame btn-block mt-1" id="volgende" href=veilen2.php?id='.$resultaat[0]['rubrieknummer'].'&naam='.$resultaat[0]['rubrieknaam'].' name="volgende">Volgende</a>';
        }
    }

    catch (PDOexception $e) {
        // echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function directorieVinden($pagina){
    $id = (end($_SESSION['catogorie']) );
    $teller = 0;
    try {
        require('core/dbconnection.php');
        $catogorien = $dbh->prepare("select * from Rubrieken where superrubriek = :id ");
        $catogorien -> execute(
            array(
                ':id' =>  $id,
            )
        );

        $print = $catogorien->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $print as $Name => $id){ 
            echo '<a class="btn btn-outline-dark"  
                    href="'.$pagina.'?id='.$print[$teller]['rubrieknummer'].'&naam='.$print[$teller]['rubrieknaam'].'" 
                    role="button">'.$print[$teller]['rubrieknaam'].'</a>';
            $teller++ ;
        }

        if(empty($print)){
            $terug = $dbh -> prepare("select * from Rubrieken where rubrieknummer = :id");
            $terug -> execute (
                array(
                    ':id' => $id,
                )
            );
            $resultaat = $terug->fetchAll(PDO::FETCH_ASSOC);

            if($pagina == 'catalogus.php'){
                echo '<a class="btn btn-outline-dark"  
                    href="'.$pagina.'?id='.$resultaat[0]['superrubriek'].'&naam='.$resultaat[0]['rubrieknaam'].'" 
                    role="button">Er zijn geen sub-catogorien beschikbaar. Klik hier om terug te gaan</a>';
            }

        }

    } catch (PDOexception $e) {
        // echo "er ging iets mis error: {$e->getMessage()}";
    }
}

//deze functie laadt de tabel met gebruikers in in de beheeromgeving overzichtGebruikers.php
function gebruikersvinden($gebruikersnaam){
    $teller = 0;
    try {
        require('core/dbconnection.php');
        $gebruikers = $dbh->prepare("
                    select gebruikersnaam, voornaam, achternaam, geslacht, postcode, plaatsnaam, land,  email, verkoper, geblokeerd 
                    from Gebruiker 
                    where gebruikersnaam like :gebruikersnaam 
                    ");
        // kan geen like '% $gebruiker%' door prepared statement
        $gebruikers -> execute(
            array(
                ':gebruikersnaam' => '%'.$gebruikersnaam.'%',
            )
        );
        $resultaten =  $gebruikers ->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $resultaten as $resultaat ){
            $teller ++;
            $verkoper = "error";
            $geblokeerd = "error";
            if ($resultaat['verkoper'] == 1){
                $verkoper = "Ja";
            }else{
                $verkoper = "nee";
            }
            if ($resultaat['geblokeerd'] == 1){
                $geblokeerd = "Ja";
            }else{
                $geblokeerd = "Nee";
            }
            echo '<tr>
                    <th scope="row">'.$teller.'</th>
                    <td>'.$resultaat['gebruikersnaam'].'</td>
                    <td>'.$resultaat['voornaam'].'</td>
                    <td>'.$resultaat['achternaam'].'</td>
                  
                    <td>'.$resultaat['postcode'].'</td>
                    <td>'.$resultaat['plaatsnaam'].'</td>
                    <td>'.$resultaat['land'].'</td>
                    <td>'.$resultaat['email'].'</td> 
                    <td>'.$verkoper.'</td>       
                    <td>'.$geblokeerd.'</td> 
                      ';
            blokeren($geblokeerd, $teller, $resultaat['gebruikersnaam'] ); 
            echo ' </tr>';

        }
    } catch (PDOexception $e) {
        // echo "er ging iets mis error: {$e->getMessage()}";
    }
}

//deze functie regelt de blokkeer/deblokkeer knop die rechts naast de gebruiker staat in de beheeromgeving
function blokeren($geblokeerd, $teller, $gebruiker){
    if ($geblokeerd == "Ja"){
        echo ' <td>   
    <a class="btn btn-primary" href="overzichtGebruikers.php?id='.$teller.'&naam='.$gebruiker.'" role="button">Deblokeer</a> 
   </td> ';
    } else if ($geblokeerd == "Nee"){
        echo ' <td>
    <a class="btn btn-primary" href="overzichtGebruikers.php?id='.$teller.'&naam='.$gebruiker.'" role="button">Blokeer</a>
      </td>  ';
    }
}

//deze functie blokkeert of deblokkeert de gebruiker in de database als de beheerder dit via de beheerdersomgeving dit aanstuurt
function gebruikerblok(){
    try {
        require('core/dbconnection.php');
        $blokeren = $dbh ->prepare (" UPDATE Gebruiker
                                    SET geblokeerd = 1
                                    WHERE gebruikersnaam like :gebruiker
                                    ");
        $deblokeren = $dbh ->prepare (" UPDATE Gebruiker
                                    SET geblokeerd = 0
                                    WHERE gebruikersnaam like :gebruiker
                                    ");
        $gebruiker = $dbh ->prepare (" SELECT * FROM Gebruiker where gebruikersnaam like :gebruiker
                                    ");
        $gebruiker -> execute(
            array(
                ':gebruiker' => $_GET['naam'],
            )
        );
        $resultaat =  $gebruiker ->fetchAll(PDO::FETCH_ASSOC);
        if ($resultaat[0]['geblokeerd'] == 1){
            StuurGebruikerDeblockedEmail($resultaat[0]['gebruikersnaam']);
            $deblokeren -> execute(
                array(
                    ':gebruiker' => $resultaat[0]['gebruikersnaam'],
                )
            );
        }else if ($resultaat[0]['geblokeerd'] == 0){
            StuurGebruikerBlockedEmail($resultaat[0]['gebruikersnaam']);
            $blokeren -> execute(
                array(
                    ':gebruiker' => $resultaat[0]['gebruikersnaam'],
                )
            );
        }
    } catch (PDOexception $e) {
        //        echo "er ging iets mis error: {$e->getMessage()}";
    }
}


/* stuurt email naar gebruiker wanneer deze geblokkeerd is */
function StuurGebruikerBlockedEmail($gebruikersnaam)
{
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select email, voornaam from Gebruiker where gebruikersnaam = :gebruikersnaam");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruikersnaam,
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );
        $from = "no-reply@iconcepts.nl";
        $to = $records['email'];
        $subject = "Account geblokkeerd";
        $message = 'Beste  '.$records['voornaam'].',
                 
                  
         Helaas moeten wij u op de hoogte stellen dat uw account is geblokkeerd. Dit kan meerdere redenen hebben.
         Om meer informatie te krijgen kunt u contact met ons opnemen door een mail te sturen naar: EenmaalAndermaal@gmail.com
         Vermeld in deze mail uw gebruikersnaam.
         Wij hopen u zodoende genoeg informatie te hebben gegeven.
                       
         Met vriendelijke groeten,
                        
         EenmaalAndermaal  
';
        $headers = "From:" .$from;
        mail($to,$subject,$message, $headers);

    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

/* stuurt email naar gebruiker wanneer deze gedeblokkeerd is */
function StuurGebruikerDeblockedEmail($gebruikersnaam)
{
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select email, voornaam from Gebruiker where gebruikersnaam = :gebruikersnaam");

        $sqlSelect->execute(
            array(
                ':gebruikersnaam' => $gebruikersnaam,
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

        ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );
        $from = "no-reply@iconcepts.nl";
        $to = $records['email'];
        $subject = "Account gedeblokkeerd";
        $message = ' Beste '.$records['voornaam'].',
                 
        Uw account is gedeblokkeerd. U kunt nu weer inloggen.
        Wij hopen u zodoende genoeg informatie te hebben gegeven.
                       
        Met vriendelijke groeten,
                        
        EenmaalAndermaal     
';
        $headers = "From:" .$from;
        mail($to,$subject,$message, $headers);

    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}


function veilingenVinden($veilingnaam){
    $teller =0;
    try {
        require('core/dbconnection.php');
        $veilingen = $dbh ->prepare (" select * from Voorwerp Where titel like :titel");
        $veilingen -> execute(
            array(
                ':titel' => '%'.$veilingnaam.'%',
            )
        );
        $veiling = $veilingen ->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $veiling as $resultaat ){
            $teller ++;
            $geblokkeerd = "error";
            if ($resultaat['geblokkeerd'] == 1){
                $geblokkeerd = "Ja";
            }else{
                $geblokkeerd = "Nee";
            }
            echo '<tr>
                    <th scope="row">'.$teller.'</th>
                    <td>'.$resultaat['voorwerpnr'].'</td>
                    <td>'.$resultaat['titel'].'</td>
                    <td>'.$resultaat['startprijs'].'</td>
                    <td>'.$resultaat['betalingswijze'].'</td>
                    <td>'.$resultaat['plaatsnaam'].'</td>
                    <td>'.$resultaat['land'].'</td>
                    <td>'.$resultaat['looptijd'].'</td>
                    <td>'.$resultaat['looptijdbegindatum'].'</td> 
                    <td>'.$resultaat['looptijdeinddatum'].'</td> 
                    <td>'.$resultaat['verkoper'].'</td> 
                    <td>'.$resultaat['veilinggesloten'].'</td> 
                    <td>'.$geblokeerd.'</td> 
                    <td>'.$resultaat['blokeerdatum'].'</td>
                      ';
            veilingblokeren($geblokkeerd, $resultaat['voorwerpnr'], $resultaat['titel'] ); 

            echo '</tr>';
        }   
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function veilingblokeren($geblokkeerd, $voorwerpnummer, $titel){
    if ($geblokkeerd == "Ja"){
        echo ' <td>   
    <a class="btn btn-primary" href="overzichtVeilingen.php?voorwerpnummer='.$voorwerpnummer.'&naam='.$titel.'" role="button">Deblokeer</a> 
   </td> ';
    } else if ($geblokkeerd == "Nee"){
        echo ' <td>
    <a class="btn btn-primary" href="overzichtVeilingen.php?voorwerpnummer='.$voorwerpnummer.'&naam='.$titel.'" role="button">Blokeer</a>
      </td>  ';
    }
}

function veilingblok($voorwerpnummer){
    try {
        require('core/dbconnection.php');

        $blokeren = $dbh ->prepare (" UPDATE Voorwerp
                                    SET geblokkeerd = 1, blokkeerdatum = CURRENT_TIMESTAMP
                                    WHERE voorwerpnr like :voorwerpnummer
                                    ");
        $deblokeren = $dbh ->prepare (" UPDATE Voorwerp
                                    SET geblokkeerd = 0
                                    WHERE voorwerpnr like :voorwerpnummer
                                    ");
        $veiling = $dbh ->prepare (" SELECT * FROM Voorwerp where voorwerpnr like :voorwerpnummer
                                    ");
        $veiling -> execute(
            array(
                ':voorwerpnummer' => $voorwerpnummer,
            )
        );


        $resultaat = $veiling ->fetchAll(PDO::FETCH_ASSOC);
        if ($resultaat[0]['geblokkeerd'] == 1){
            $deblokeren -> execute(
                array(
                    ':voorwerpnummer' => $resultaat[0]['voorwerpnr'],
                )
            );
            veilingeindberekenen ($resultaat[0]['voorwerpnr']);
        }else if ($resultaat[0]['geblokkeerd'] == 0){
           // $records =  HaalBiederEnVerkoperOp($voorwerpnummer, $verkoper);
           // VerstuurVeilingBlockedMail($veiling, $ontvanger;
            $blokeren -> execute(
                array(
                    ':voorwerpnummer' => $resultaat[0]['voorwerpnr'],
                )
            );
        }


    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function checkGEBLOKEERD($gebruiker){
    try {
        require('core/dbconnection.php');
        $geblokeerd = $dbh ->prepare ("select gebruikersnaam, geblokeerd from Gebruiker where gebruikersnaam like :gebruiker  ");
        $geblokeerd-> execute(
            array(
                ':gebruiker' => $gebruiker,

            )
        );

        while ($resultaat = $geblokeerd ->fetchAll(PDO::FETCH_ASSOC)){
            if ($resultaat[0]['geblokeerd'] == 1){
                return true;
            }else if ($resultaat[0]['geblokeerd'] == 0){
                return false;
            } else if (empty($resultaat[0]['geblokeerd'])){
                //header("Location: includes/404error.php");
            }
        }
    } catch (PDOexception $e) {
        //    echo "er ging iets mis error: {$e->getMessage()}";
    }

}

function checkBEHEERDER ($gebruiker){
    try {
        require('core/dbconnection.php');
        $geblokeerd = $dbh ->prepare (" select gebruikersnaam, beheerder from Gebruiker where gebruikersnaam like :gebruiker ");
        $geblokeerd-> execute(
            array(
                ':gebruiker' => $gebruiker,
            )
        );

        while ($resultaat = $geblokeerd ->fetchAll(PDO::FETCH_ASSOC)){
            if ($resultaat[0]['beheerder'] == 1){
                return true;
            }else if ($resultaat[0]['beheerder'] == 0){  
                return false;
            } else if (empty($resultaat['beheerder'])){
                //header("Location: includes/404error.php");
            }
        }
    } catch (PDOexception $e) {
        //echo "er ging iets mis error: {$e->getMessage()}";
        // blijft error geven vanwegen het niet meer opkunnen halen van meet data. 
    }
}

function veilingeindberekenen ($voorwerpnummer){
       // de overgebleven dagen die de veiling nog open is.
    try {
        require('core/dbconnection.php');
        $informatie = $dbh -> prepare("SELECT * from Voorwerp where voorwerpnr = :voorwerpnr");
        // haalt de algemene informatie op die nodig is voor de berekening
        $einddatum = $dbh -> prepare ("UPDATE Voorwerp set looptijdeindedagtijdstip = (select  
          DATEADD(DAY, (SELECT DATEDIFF(DAY, CURRENT_TIMESTAMP, blokkeerdatum) from Voorwerp where blokkeerdatum > '2000-01-01' and voorwerpnr = :voorwerpnr),
          (select looptijdeindedagtijdstip from Voorwerp where voorwerpnr = :voorwerpnr1)))
		        where voorwerpnr = :voorwerpnr2"); // insert de       nieuwe einddatum gebaseerd op de ( looptijd - het aantal dagen tussen begin- en blokeer- datum )
        //====================================================================================================//
        // informatie query runnen en afhandelen.
        $informatie -> execute(
            array(
                ':voorwerpnr' => $voorwerpnummer
              
            )
        );
      
        $einddatum -> execute (
            array (
                ':voorwerpnr' => $voorwerpnummer,
                ':voorwerpnr1' => $voorwerpnummer,
                ':voorwerpnr2' => $voorwerpnummer
              
            )
        );
    } catch (PDOexception $e) {
        echo "er ging iets mis error123: {$e->getMessage()}";
    }
}

function HaalMijnAdvertentieOp($gebruikersnaam){
  
  try {
      require('core/dbconnection.php');
      $sqlSelect = $dbh ->prepare ("SELECT voorwerpnr from Voorwerp where verkoper = :gebruiker ");
      $sqlSelect-> execute(
          array(
              ':gebruiker' => $gebruikersnaam
          )
      );
      $resultaat = $sqlSelect ->fetchAll(PDO::FETCH_ASSOC);
      return $resultaat;

  } catch (PDOexception $e) {
      "er ging iets mis error: {$e->getMessage()}";
      
  }
}

function HaalBiederEnVerkoperOp($voorwerpnr, $verkoper){
  
  try {
      require('core/dbconnection.php');
      $sqlSelect = $dbh ->prepare ("SELECT * from Gebruiker where gebruikersnaam = (select top 1 gebruikersnaam from bod where voorwerpnr = :voorwerpnr order by convert(decimal(9,2), euro) desc )
                                    UNION
                                    SELECT * from Gebruiker where gebruikersnaam = :verkoper
                                    ");
      $sqlSelect2 = $dbh ->prepare ("SELECT * from Voorwerp where voorwerpnr = :voorwerpnr");
        
          $sqlSelect ->execute( 
                     array(':voorwerpnr' => $voorwerpnr,
                           ':verkoper' => $verkoper));
                           
           $sqlSelect2 ->execute( array(':voorwerpnr' => $voorwerpnr));
                        
           $records = $sqlSelect ->fetchAll(PDO::FETCH_ASSOC);
           
           array_push($records, $sqlSelect2 ->fetch(PDO::FETCH_ASSOC));
           
           return $records;
              
  } catch (PDOexception $e) {
      "er ging iets mis error: {$e->getMessage()}";      
  }  
  
}

function VerkoopVeiling($voorwerpnr){
  
  try {
      require('core/dbconnection.php');      
      $sqlUpdate = $dbh ->prepare ("UPDATE Voorwerp
                                    SET koper = (select top 1 gebruikersnaam from bod where voorwerpnr = :voorwerpnr order by convert(decimal(9,2), euro) desc),
                                        verkoopprijs = (select top 1 euro from bod where voorwerpnr = :voorwerpnr1 order by convert(decimal(9,2), euro) desc),
                                        veilinggesloten = 1
                                    WHERE voorwerpnr = :voorwerpnr2");      
      $sqlUpdate-> execute(
          array(
              ':voorwerpnr' => $voorwerpnr,
              ':voorwerpnr1' => $voorwerpnr,
              ':voorwerpnr2' => $voorwerpnr
          ));
              
  } catch (PDOexception $e) {
      "er ging iets mis error: {$e->getMessage()}";      
  }  
}

function VerwijderVeiling($voorwerpnr, $verkoper){
  
  try {
      require('core/dbconnection.php');   
      $records =  HaalBiederEnVerkoperOp($voorwerpnr, $verkoper);                             
      $sqlDelete1 = $dbh ->prepare ("DELETE FROM Voorwerpinrubriek where voorwerpnr = :voorwerpnr");
      $sqlDelete2 = $dbh ->prepare ("DELETE FROM laatstbekeken where voorwerpnr = :voorwerpnr"); 
      $sqlDelete3 = $dbh ->prepare ("DELETE FROM Voorwerp where voorwerpnr = :voorwerpnr");
      
     $sqlDelete1-> execute( array(':voorwerpnr' => $voorwerpnr ));
     $sqlDelete2-> execute( array(':voorwerpnr' => $voorwerpnr ));
     $sqlDelete3-> execute( array(':voorwerpnr' => $voorwerpnr ));         
      
      return $records;
      
  } catch (PDOexception $e) {
      "er ging iets mis error: {$e->getMessage()}";      
  }  
}

function VerstuurVerkoopMail($veiling, $ontvanger){

    if($ontvanger){
        ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );
        $from = "no-reply@iconcepts.nl";
        $to = $veiling[0]['email'];
        $subject = "EenmaalAndermaal u heeft een voorwerp Verkocht!";
        $message = emailVerkocht($veiling);
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:" .$from;

        mail($to,$subject,$message, $headers);
    }

    if($ontvanger == false){
        ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );
        $from = "no-reply@iconcepts.nl";
        $to = $veiling[1]['email'];
        $subject = "EenmaalAndermaal u heeft een voorwerp Gekocht!";
        $message = EmailGekocht($veiling);

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:" .$from;

        mail($to,$subject,$message, $headers);
    }  
}



function VerstuurVeilingBlockedMail($veiling, $ontvanger){

    if($ontvanger){
      
        ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );
        $from = "no-reply@iconcepts.nl";
        $to = $veiling[0]['email'];
        $subject = "EenmaalAndermaal u heeft een voorwerp Verkocht!";
        $message = emailVeilingBlockedVerkoper($veiling);
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:" .$from;

        mail($to,$subject,$message, $headers);
    }

    if($ontvanger == false){
      
        ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );
        $from = "no-reply@iconcepts.nl";
        $to = $veiling[1]['email'];
        $subject = "EenmaalAndermaal u heeft een voorwerp Gekocht!";
        $message = emailVeilingBlockedKoper($veiling);

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:" .$from;

        mail($to,$subject,$message, $headers);
    }
}


function VerstuurVerwijderMail($veiling, $ontvanger){
  $id = 2;
  if(empty($veiling[2])){$id = 1;}
  
  if($ontvanger){
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "no-reply@iconcepts.nl";
    $to = $veiling[1]['email'];
    $subject = "EenmaalAndermaal uw voorwerp is verwijderd";
    $message = EmailVerwijderdVerkoper($veiling, $id);
  
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From:" .$from;
  
    mail($to,$subject,$message, $headers);
  }
  
  if($ontvanger == false){
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "no-reply@iconcepts.nl";
    $to = $veiling[0]['email'];
    $subject = "EenmaalAndermaal geboden voorwerp is verwijderd";
    $message = EmailVerwijderdHoogstebod($veiling);
  
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From:" .$from;
  
    mail($to,$subject,$message, $headers);
  }  
}
?>