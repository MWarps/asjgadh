<?php

require_once 'dbconnection.php';
include '../includes/emailEindeLooptijdKoper.php';
include '../includes/emailEindeLooptijdVerkoper.php';
// controleerd of de CronJob de pagina ophaald door de checken voor de unieke gegevens die de CronJob heeft.

checkBotAdvertentie ('asjgadh'); 
checkNormaleAdvertenties('asjgadh');

// controleerd alle bot veilingen die nog openstaan.
function checkBotAdvertentie ($botEMail){
    $botteller = 0; // houdt bij hoevaak de functie heeft gerunt
    $blokker = 0;
    try {
        require ('dbconnection.php');
        // algemene query voor het wijzigen van de veilingstatus naar 1 ('gesloten')
        $sluitVeiling = $dbh -> prepare(' update Voorwerp set veilinggesloten = 1  where voorwerpnr = :voorwerpnr ');
        // haalt alle veilingen op die de opgegeven bot code in het email adress bevatten
        $botVeiling = $dbh -> prepare(' select voorwerpnr, looptijdeindedagtijdstip, V.verkoper, veilinggesloten from Voorwerp V, Gebruiker G where  G.gebruikersnaam = V.verkoper and G.email like :botnaam and veilinggesloten = 0 '); 

        $botVeiling -> execute(array (':botnaam' => '%'.$botEMail.'%' ) );

        while ($bot = $botVeiling ->fetch(PDO::FETCH_ASSOC)){


            if ((date("d.m.Y H:i", strtotime($bot['looptijdeindedagtijdstip'])) ) <= date("d.m.Y H:i:s")){
                if ($bot[$botteller]['veilinggesloten'] == 0){
                    $sluitVeiling -> execute( array(':voorwerpnr' => $bot['voorwerpnr'] ));
                    $botteller ++;
                    $blokker ++;
                } else {
                    $botteller ++;
                }
            }else{
                $botteller ++; 
            }
        }
    } catch (PDOexception $e) {
        "er ging iets mis error: {$e->getMessage()}"; 
    }
    echo('Aantal Bot advertentie: ');echo ($botteller); echo('<br>');
    echo('Aantal Bot advertentie gesloten: ');echo ($blokker); echo('<br>');
}

// controleerd alle veilingen die niet van de bots zijn die nog openstaan.
function checkNormaleAdvertenties($botEMail){
    $klantteller = 0;// houdt bij hoeveel veilingen de functie heeft gechecked
    $blokker = 0;
    try {
        require ('dbconnection.php');
        // algemene query voor het sluiten van veilingen
        $sluitVeiling = $dbh -> prepare(' update Voorwerp set veilinggesloten = 1  where voorwerpnr = :voorwerpnr '); 
        // haalt alle veilingen op die nog openstaand en waarvan de email niet de bot code bevat.
        $haalVeilingenOp = $dbh -> prepare(' select * from Voorwerp V, Gebruiker G where  G.gebruikersnaam = V.verkoper and G.email not like :botnaam and veilinggesloten = 0 ');
 
        $haalVeilingenOp -> execute( array (':botnaam' => '%'.$botEMail.'%' ) );
        
        while ($resultaat = $haalVeilingenOp ->fetch(PDO::FETCH_ASSOC)){  
            if ((date("d.m.Y H:i", strtotime($resultaat['looptijdeindedagtijdstip'])) ) <= date("d.m.Y H:i:s")){
                
                if ($resultaat['veilinggesloten'] == 0){
                    
                    $veiling = HaalBiederEnVerkoperOp1($resultaat['voorwerpnr'],$resultaat['gebruikersnaam']);
                    
                    VerstuurEindeLooptijdMail1($veiling, false);
                    
                    if(count($veiling) == 3){
                        VerstuurEindeLooptijdMail1($veiling, true);
                    }
                    
                    $sluitVeiling -> execute( array(':voorwerpnr' => $resultaat['voorwerpnr'] ));
                    $klantteller++;
                    $blokker ++;
                } else {
                    $klantteller ++;
                }
            }else{
                $klantteller ++;
            }
        } 
    } catch (PDOexception $e) {
        "er ging iets mis error: {$e->getMessage()}"; 
    }
    echo('Aantal Klant advertentie NR : ');echo ($klantteller);echo('<br>');
    echo('Geblokeerde Klant advertentie NR : ');echo ($blokker);echo('<br>');
}

function HaalBiederEnVerkoperOp1($voorwerpnr, $verkoper)
{
    try {
        require('dbconnection.php');
        $sqlSelect = $dbh->prepare("
        SELECT * FROM Gebruiker WHERE gebruikersnaam = (SELECT top 1 gebruikersnaam FROM bod WHERE voorwerpnr = :voorwerpnr ORDER BY CONVERT(DECIMAL(9,2), euro) DESC)
      ");

        $sqlSelect2 = $dbh->prepare("
        SELECT * FROM Gebruiker WHERE gebruikersnaam = :verkoper
      ");

        $sqlSelect3 = $dbh->prepare("
        SELECT * FROM Voorwerp WHERE voorwerpnr = :voorwerpnr
      ");

        $sqlSelect->execute(
            array(':voorwerpnr' => $voorwerpnr));
        $sqlSelect2->execute(
            array(':verkoper' => $verkoper));
        $sqlSelect3->execute(
            array(':voorwerpnr' => $voorwerpnr));

        $records = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
        array_push($records, $sqlSelect2->fetch(PDO::FETCH_ASSOC));
        array_push($records, $sqlSelect3->fetch(PDO::FETCH_ASSOC));

        return $records;
    } catch (PDOexception $e) {
        "er ging iets mis error: {$e->getMessage()}";
    }

}

// deze functie verstuurd een mail naar de verkoper waar de advertentie over datum is
// wordt gebruikt in:
function VerstuurEindeLooptijdMail1($veiling, $ontvanger)
{
  $voorwerp = 1;
  $verkoper = 0;
  if (count($veiling) == 3) {
      $verkoper = 1;
      $voorwerp = 2;
  }

    $verkopermail = $veiling[$verkoper]['email'];
    $kopermail = $veiling[0]['email'];

    if ($ontvanger == false) {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $from = "no-reply@iconcepts.nl";
        $to = $verkopermail;
        $subject = "EenmaalAndermaal uw voorwerp is verwijderd";
        $message = emailEindeLooptijdVerkoper($veiling, $voorwerp, $verkoper);

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:" . $from;

        mail($to, $subject, $message, $headers);
    }

    if ($ontvanger) {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $from = "no-reply@iconcepts.nl";
        $to = $kopermail;
        $subject = "EenmaalAndermaal geboden voorwerp is verwijderd";
        $message = emailEindeLooptijdKoper($veiling);

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From:" . $from;

        mail($to, $subject, $message, $headers);
    }
}
?>