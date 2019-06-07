<?php
/*
 * TODO LIST
 * - veilingblok updaten uit functies.php
 * - geblokeerd in query's over de gebruiker hernoemen naar geblokkeerd
 */

include 'brief.php';

// CommentaarNodig
// verplaatst naar beheerderFuncties.php
function veilingenVinden($veilingnaam){
    $teller =0;
    try {
        require('core/dbconnection.php');
        $veilingen = $dbh ->prepare ("
          SELECT * FROM Voorwerp WHERE titel LIKE :titel
        ");

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
                    <td>'.$geblokkeerd.'</td> 
                    <td>'.$resultaat['blokeerdatum'].'</td>
                      ';

            veilingblokkeren($geblokkeerd, $resultaat['voorwerpnr'], $resultaat['titel'] );

            echo '</tr>';
        }
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// CommentaarNodig
// verplaatst naar beheerderFuncties.php
function veilingblokkeren($geblokkeerd, $voorwerpnummer, $titel){
    if ($geblokkeerd == "Ja"){
        echo ' <td>   
    <a class="btn btn-primary" href="overzichtVeilingen.php?voorwerpnummer='.$voorwerpnummer.'&naam='.$titel.'" role="button">Deblokkeer</a> 
   </td> ';
    } else if ($geblokkeerd == "Nee"){
        echo ' <td>
    <a class="btn btn-primary" href="overzichtVeilingen.php?voorwerpnummer='.$voorwerpnummer.'&naam='.$titel.'" role="button">Blokkeer</a>
      </td>  ';
    }
}

// CommentaarNodig
// verplaatst naar beheerderFuncties.php
// nog een keer updaten met de versie uit functies.php - Gedaan
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

        $resultaat = $veiling ->fetch(PDO::FETCH_ASSOC);
        
        if ($resultaat['geblokkeerd'] == 1){
            $deblokeren -> execute(
                array(
                    ':voorwerpnummer' => $resultaat['voorwerpnr'],
                ));
                
            veilingeindberekenen ($resultaat['voorwerpnr']);
        }
        else if ($resultaat['geblokkeerd'] == 0){

            $veiling = HaalBiederEnVerkoperOp($voorwerpnummer, $resultaat['verkoper']);
            VerstuurVeilingBlockedMail($veiling, true);
            
            if(count($veiling) == 3){
            VerstuurVeilingBlockedMail($veiling, false);
          }
            $blokeren -> execute(
                array(
                    ':voorwerpnummer' => $resultaat['voorwerpnr']
                ));
        }


    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// berekent de overgebleven dagen die de veiling nog open is. wanneer de veiling gedeblokkeerd wordt
//verplaatst naar beheerderFuncties.php
function veilingeindBerekenen ($voorwerpnummer){
    try {
        require('core/dbconnection.php');
        $informatie = $dbh -> prepare("
          SELECT * FROM Voorwerp WHERE voorwerpnr = :voorwerpnr
        ");
        // haalt de algemene informatie op die nodig is voor de berekening
        $einddatum = $dbh -> prepare ("
          UPDATE Voorwerp 
          SET looptijdeindedagtijdstip = (
                                          SELECT DATEADD(DAY, (SELECT DATEDIFF(DAY, CURRENT_TIMESTAMP, blokkeerdatum) FROM Voorwerp WHERE blokkeerdatum > '2000-01-01' AND voorwerpnr = :voorwerpnr),
                                          (SELECT looptijdeindedagtijdstip from Voorwerp where voorwerpnr = :voorwerpnr1)))
		  WHERE voorwerpnr = :voorwerpnr2
		"); // insert de       nieuwe einddatum gebaseerd op de ( looptijd - het aantal dagen tussen begin- en blokeer- datum )
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

// deze functie laadt de tabel met gebruikers in in de beheeromgeving overzichtGebruikers.php
// verplaatst naar beheerderFuncites.php
function gebruikersvinden($gebruikersnaam){
    $teller = 0;
    try {
        require('core/dbconnection.php');
        $gebruikers = $dbh->prepare("
          SELECT gebruikersnaam, voornaam, achternaam, geslacht, postcode, plaatsnaam, land,  email, verkoper, geblokeerd
          FROM Gebruiker
          WHERE gebruikersnaam LIKE :gebruikersnaam
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
            $geblokkeerd = "error";
            if ($resultaat['verkoper'] == 1){
                $verkoper = "Ja";
            }else{
                $verkoper = "nee";
            }
            if ($resultaat['geblokeerd'] == 1){
                $geblokkeerd = "Ja";
            }else{
                $geblokkeerd = "Nee";
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
                    <td>'.$geblokkeerd.'</td> 
                      ';
            blokkeren($geblokkeerd, $teller, $resultaat['gebruikersnaam'] );
            echo ' </tr>';

        }
    } catch (PDOexception $e) {
        // echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// deze functie regelt de blokkeer/deblokkeer knop die rechts naast de gebruiker staat in de beheeromgeving
function blokkeren($geblokkeerd, $teller, $gebruiker){
    if ($geblokkeerd == "Ja"){
        echo ' <td>   
    <a class="btn btn-primary" href="overzichtGebruikers.php?id='.$teller.'&naam='.$gebruiker.'" role="button">Deblokkeer</a> 
   </td> ';
    } else if ($geblokkeerd == "Nee"){
        echo ' <td>
    <a class="btn btn-primary" href="overzichtGebruikers.php?id='.$teller.'&naam='.$gebruiker.'" role="button">Blokkeer</a>
      </td>  ';
    }
}

// deze functie blokkeert of deblokkeert de gebruiker in de database als de beheerder dit via de beheerdersomgeving dit aanstuurt
function gebruikerblok(){
    try {
        require('core/dbconnection.php');
        $blokkeren = $dbh ->prepare ("
          UPDATE Gebruiker
          SET geblokeerd = 1
          WHERE gebruikersnaam LIKE :gebruiker
        ");

        $deblokkeren = $dbh ->prepare ("
            UPDATE Gebruiker
            SET geblokeerd = 0
            WHERE gebruikersnaam LIKE :gebruiker
          ");

        $gebruiker = $dbh ->prepare ("
          SELECT * FROM Gebruiker WHERE gebruikersnaam LIKE :gebruiker
        ");

        $gebruiker -> execute(
            array(
                ':gebruiker' => $_GET['naam'],
            )
        );
        $resultaat =  $gebruiker ->fetchAll(PDO::FETCH_ASSOC);
        if ($resultaat[0]['geblokeerd'] == 1){
            StuurGebruikerDeblockedEmail($resultaat[0]['gebruikersnaam']);
            $deblokkeren -> execute(
                array(
                    ':gebruiker' => $resultaat[0]['gebruikersnaam'],
                )
            );
        }else if ($resultaat[0]['geblokeerd'] == 0){
            StuurGebruikerBlockedEmail($resultaat[0]['gebruikersnaam']);
            $blokkeren -> execute(
                array(
                    ':gebruiker' => $resultaat[0]['gebruikersnaam'],
                )
            );
        }
    } catch (PDOexception $e) {
        //        echo "er ging iets mis error: {$e->getMessage()}";
    }
}


// stuurt email naar gebruiker wanneer deze geblokkeerd is
function StuurGebruikerBlockedEmail($gebruikersnaam)
{
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT email, voornaam FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam 
        ");

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

// stuurt email naar gebruiker wanneer deze gedeblokkeerd is
function StuurGebruikerDeblockedEmail($gebruikersnaam)
{
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT email, voornaam FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam
        ");

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

// deze methode laad alle verificaties om verkoper te worden die nog niet verzonden zijn. ook wordt het adress en de brief volgens een template vast opgesteld
function verificatiesVinden(){
    $teller = 0;
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          SELECT Gebruiker.voornaam, Gebruiker.achternaam, Gebruiker.email, Gebruiker.geslacht, Gebruiker.adresregel1, Gebruiker.adresregel2, Gebruiker.postcode, Gebruiker.plaatsnaam, Gebruiker.land, Verificatie.verificatiecode, 
          Verificatie.eindtijd FROM Gebruiker INNER JOIN Verificatie ON Gebruiker.email = Verificatie.email WHERE type = 'brief' AND verzonden = 0
        ");

        $sqlSelect->execute();

        $verkopers = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);

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

// deze functie registreerd dat de brief verzonden is in de database
function verificatieVerzonden($email) {
    $email = fixEmail($email);
    try{
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("
          UPDATE Verificatie SET verzonden = 1 WHERE email = :email
        ");

        $sqlSelect->execute(
            array(
                ':email' => $email
            ));
    }
    catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

// de $_GET die gebruikt wordt om de email op te halen en naar verificatieVerzonden te sturen verandert de + tekens in de email adressen naar spaties
function fixEmail($email) {
    $email = str_replace(" ","+",$email);
    return $email;
}