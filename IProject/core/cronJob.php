<?php
require '../includes/functies.php';
require_once 'dbconnection.php';

if( ( isset($_SERVER['PHP_AUTH_USER'] ) && ( $_SERVER['PHP_AUTH_USER'] == "CronJob" ) ) AND
      ( isset($_SERVER['PHP_AUTH_PW'] ) && ( $_SERVER['PHP_AUTH_PW'] == "CronJob" )) ) {
checkBotAdvertentie ('asjgadh'); 
checkNormaleAdvertenties();
}

function checkBotAdvertentie ($botEMail){
    $botteller = 0;
    try {
        require ('dbconnection.php');

        $sluitVeiling = $dbh -> prepare(' update Voorwerp set veilinggesloten = 1  where voorwerpnr = :voorwerpnr ');

        $botVeiling = $dbh -> prepare(' select voorwerpnr, looptijdeindedagtijdstip, V.verkoper, veilinggesloten from Voorwerp V, Gebruiker G where  G.gebruikersnaam = V.verkoper and G.email like :botnaam and veilinggesloten = 0 ');

        $botVeiling -> execute(array (':botnaam' => '%'.$botEMail.'%' ) );

        while ($bot = $botVeiling ->fetch(PDO::FETCH_ASSOC)){
            echo('Bot (advertentie/ iteratie) NR : ');echo ($botteller); echo('<br>');

            if ((date("d.m.Y H:i", strtotime($bot['looptijdeindedagtijdstip'])) ) <= date("d.m.Y H:i:s")){
                if ($bot[$botteller]['veilinggesloten'] == 0){
                    $sluitVeiling -> execute( array(':voorwerpnr' => $bot['voorwerpnr'] ));
                    $botteller ++; // moet laatste regel zijn.
                } else {
                    $botteller ++; // moet laatste regel zijn.
                }
            }else{
                $botteller ++; // moet laatste regel zijn.
            }// einde if date-check. en else statement. 
        }// einde while
    } catch (PDOexception $e) { // openenen catch en sluiten try.
        "er ging iets mis error: {$e->getMessage()}"; 
    }// haakje voor einde try/catch.
}// einde functie voor de EenmaalAndermaal Bots.


function checkNormaleAdvertenties(){
    $klantteller = 0;
    try {
        require ('dbconnection.php');

        $sluitVeiling = $dbh -> prepare(' update Voorwerp set veilinggesloten = 1  where voorwerpnr = :voorwerpnr ');

        $haalVeilingenOp = $dbh -> prepare(' select * from Voorwerp V, Gebruiker G where  G.gebruikersnaam = V.verkoper and G.email not like %asjgadh% and veilinggesloten = 0 ');

        $haalVeilingenOp -> execute(); echo('execute succesvol');

        while ($resultaat = $haalVeilingenOp = $sqlSelect->fetch(PDO::FETCH_ASSOC)){
            echo('Klant (advertentie/ iteratie) NR : ');echo ($klantteller);echo('<br>');

            if ((date("d.m.Y H:i", strtotime($resultaat['looptijdeindedagtijdstip'])) ) <= date("d.m.Y H:i:s")){
                if ($resultaat['veilinggesloten'] == 0){
                    $sluitVeiling -> execute( array(':voorwerpnr' => $resultaat['voorwerpnr'] ));
                    $klantteller++; // moet laatste regel zijn.
                } else {
                    $klantteller ++; // moet laatste regel zijn.
                }
            }else{
                $klantteller ++; // moet laatste regel zijn.
            }// einde if date-check. en else statement. 
        } 
    } catch (PDOexception $e) { // openenen catch en sluiten try.
        "er ging iets mis error: {$e->getMessage()}"; 
    }// haakje voor einde try/catch.
}
?>