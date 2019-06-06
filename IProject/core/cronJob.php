<?php
echo ('begin php bestand'); // test tekst voor debugging 
echo ('<br>');
require '../includes/functies.php';
require_once 'dbconnection.php';


checkBotAdvertentie ('asjgadh'); echo('checkBotadvertentie heeft gelopen');echo('<br>');

function checkBotAdvertentie ($botEMail){
    echo('functie voor bots aangeroepen');echo ('<br>');
    echo ('meegegeven bot naam = '); echo($botEMail); echo ('<br>');
    $botteller = 0;
    try {
        require ('dbconnection.php');
        echo('database connectie.php ');echo('<br>');

        $sluitVeiling = $dbh -> prepare(' update Voorwerp set veilinggesloten = 1  where voorwerpnr = :voorwerpnr ');

        $botVeiling = $dbh -> prepare(' select voorwerpnr, looptijdeindedagtijdstip, verkoper, veilinggesloten from Voorwerp V, Gebruiker G where  G.gebruikersnaam = V.verkoper and G.email like :botnaam ');
        echo('querys perpared ');echo('<br>');

        $botVeiling -> execute(array (':botnaam' => '%'.$botEMail.'%' ) );
        echo ('query wordt geexecute');echo ('<br>');

        $bots = $botVeiling ->fetch(PDO::FETCH_ASSOC);
        echo ('veilingen waarin de bots als verkoper staan zijn ingeladen');echo ('<br>');

        echo ('hieronder staat de array $bots');echo ('<br>');
        print_r($bots);echo ('<br>');

        foreach ($bots as $bot){
            echo ('hieronder staat de array $bot');echo ('<br>');
            print_r($bot);echo ('<br>');
            if ((date("d.m.Y H:i", strtotime($bot[$botteller]['looptijdeindedagtijdstip'])) ) <= date("d.m.Y H:i:s")){
                if ($bot[$botteller]['veilinggesloten']){
                    $sluitVeiling -> execute( array(':voorwerpnr' => $bot[$botteller]['voorwerpnr'] ));
                }
                $botteller ++; // moet laatste regel zijn.
            }else{
                $botteller ++; // moet laatste regel zijn.
            }// einde if date-check. en else statement. 
        }// einde foreach
    } catch (PDOexception $e) { // openenen catch en sluiten try.
        "er ging iets mis error: {$e->getMessage()}"; 
    }// haakje voor einde try/catch.
}// einde functie voor de EenmaalAndermaal Bots.



//$klantteller = 0;
// $haalVeilingenOp = $dbh -> prepare(' select * from Voorwerp V, Gebruiker G where  G.gebruikersnaam = V.verkoper and G.email not like %asjgadh% ');
//
// $haalVeilingenOp -> execute();
//
//$klanten =  $haalVeilingenOp = $sqlSelect->fetch(PDO::FETCH_ASSOC);
echo ('einde php bestand');
?>