<?php
include 'email.php';
include 'email2.php';
include 'emailBericht.php';

/* advertentie ophalen */
function haalAdvertentieOp(){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("select beschrijving from voorwerp where voorwerpnr = 6576921535");

        $sqlSelect->execute(
            array(
                            
            ));
        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;
        

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


function MaakVerkoperBrief($gebruiker){
    try{    
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("SELECT voornaam, achternaam, geslacht, adresregel1, adresregel2, postcode, plaatsnaam, land, verificatiecode, 
        eindtijd FROM Gebruiker INNER JOIN Verificatie ON Gebruiker.email = Verificatie.email WHERE type = 'brief' 
        AND Gebruiker.gebruikersnaam = :gebruiker");

        $sqlSelect->execute(
            array(
                ':gebruiker' => $_SESSION['gebruikersnaam']
            ));

        $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        return $records;

        Brief($records);
    }
    catch (PDOexception $e) {
        echo "er ging iets mis erroreqrre: {$e->getMessage()}";
    }
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
        $sqlSelect = $dbh->prepare("select email, voornaam from gebruikers where gebruikersnaam = :gebruikersnaam");

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
        $sqlSelect = $dbh->prepare("select gebruiker.vraag from gebruikers join vragen
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

/*
Komen de wachtwoorden overeen bij het registreren en wachtwoord reset
function controleerWachtwoord($rWachtwoord, $rHerhaalWachtwoord)
{
    if ($rWachtwoord == $rHerhaalWachtwoord) {
        return true;
    } else {
        return false;
    }
}


function haalPostsOp($rubriek)
{
    if (empty($rubriek) || $rubriek == 'Alle rubrieken') {
        $query = 'select * from posts order by unixtijd desc';
    } else {
        $query = "select * from posts where rubriek like '$rubriek' order by unixtijd desc";
    }
    try {
        require('connecting.php');

        $sqlSelect = $dbh->prepare("$query");

        $sqlSelect->execute();

        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
        return $records;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}


function plaatsPost($kopje, $tekst, $rubriek, $dbh, $unixtijd)
{

    if ($kopje == null || $tekst == null || $rubriek == null) {
        echo 'Één van de velden is niet ingevuld ';
        header("Refresh: 2; url=forum.php");
        die();
    } else {

        try {
            require('connecting.php');

            $insertQuery = $dbh->prepare("insert into posts (kopje, tekst, bezoeker, rubriek, unixtijd) values(:kopje, :tekst, :bezoeker, :rubriek, :unixtijd)");
            $insertQuery->execute(
                array(
                    ':kopje' => $kopje,
                    ':tekst' => $tekst,
                    ':bezoeker' => $_SESSION['loginnaam'],
                    ':rubriek' => $rubriek,
                    ':unixtijd' => $unixtijd
                )
            );
        } catch (PDOexception $e) {
            echo "er ging iets mis error: {$e->getMessage()}";
        }
    }
}


function geefVideoDetails($id)
{
    try {
        require('connecting.php');
        $sqlSelect = $dbh->prepare("select * from videos where id = $id");
        $sqlSelect->execute();
        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
        return $records;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function haalVideosOp($rubriek)
{
    if (empty($rubriek) || $rubriek == 'Alle rubrieken') {
        $query = 'select * from videos';
    } else {
        $query = "select * from videos where rubriek like '$rubriek'";
    }
    try {
        require('connecting.php');

        $sqlSelect = $dbh->prepare("$query");

        $sqlSelect->execute();

        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
        return $records;

    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}
*/
function statusOpValidatieZetten($gebruikersnaam){
    try {
        require('core/dbconnection.php');
        $sqlSelect = $dbh->prepare("UPDATE Verkoper Set gevalideerd = 1 WHERE gebruikersnaam = :gebruikersnaam");

        $sqlSelect->execute(
            array (
                ':gebruikersnaam' => $gebruikersnaam,
            ));

        $verkoperVerificatie = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);

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

function catogorieSoort (){
    $teller =0;
    foreach($_SESSION['catogorie'] as $level => $id){
        if ($teller ==0){
            echo '<li class="breadcrumb-item"><a href="catalogus.php?id='.$id.'&naam='.$level.' " >'.$level.'</a></li>';
            $teller++;
        }
    }       
}

function directorieVinden(){
    $id = (end($_SESSION['catogorie']) );
    $teller = 0;
    try {
        require('core/dbconnection.php');
        $catogorien = $dbh->prepare("select * from Categorieen where parent = :id ");
        $catogorien -> execute(
            array(
                ':id' =>  $id,
            )
        );

        $print = $catogorien->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $print  as $Name => $id){
            echo '<a class="btn btn-outline-dark"  
            href="catalogus.php?id='.$print[$teller]['ID'].'&naam='.$print[$teller]['Name'].'" 
            role="button">'.$print[$teller]['Name'].'</a>';
            $teller++ ;
        }
    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

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
                    <td>'.$resultaat['geslacht'].'</td>
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
            $deblokeren -> execute(
            array(
                ':gebruiker' => $resultaat[0]['gebruikersnaam'],
            )
        );
        }else if ($resultaat[0]['geblokeerd'] == 0){
            $blokeren -> execute(
            array(
                ':gebruiker' => $resultaat[0]['gebruikersnaam'],
            )
        );
        }


    } catch (PDOexception $e) {
        echo "er ging iets mis error: {$e->getMessage()}";
    }
}

function veilingenVinden ($veilingnaam){
        
}
?>