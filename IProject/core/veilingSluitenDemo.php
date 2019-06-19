<?php
require '../includes/functies.php';
require_once 'dbconnection.php';
// controleerd of de CronJob de pagina ophaald door de checken voor de unieke gegevens die de CronJob heeft.

checkBotAdvertentie ('asjgadh'); 
checkNormaleAdvertenties();

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
function checkNormaleAdvertenties(){
   
    $klantteller = 0;// houdt bij hoeveel veilingen de functie heeft gechecked
    $blokker = 0;
    try {
        require ('dbconnection.php');
        // algemene query voor het sluiten van veilingen
        $sluitVeiling = $dbh -> prepare(' update Voorwerp set veilinggesloten = 1  where voorwerpnr = :voorwerpnr '); 
        // haalt alle veilingen op die nog openstaand en waarvan de email niet de bot code bevat.
        $haalVeilingenOp = $dbh -> prepare(' select * from Voorwerp V, Gebruiker G where  G.gebruikersnaam = V.verkoper and G.email not like %asjgadh% and veilinggesloten = 0 ');
 
        $haalVeilingenOp -> execute();
        
        while ($resultaat = $haalVeilingenOp = $sqlSelect->fetch(PDO::FETCH_ASSOC)){  
            echo('we zitten nu in while loop');
            if ((date("d.m.Y H:i", strtotime($resultaat['looptijdeindedagtijdstip'])) ) <= date("d.m.Y H:i:s")){
                if ($resultaat['veilinggesloten'] == 0){

                    $veiling = HaalBiederEnVerkoperOp($resultaat['voorwerpnr'], $resultaat['verkoper']);
                    VerstuurEindeLooptijdMail($veiling, true);

                    if(count($veiling) == 3){
                        VerstuurEindeLooptijdMail($veiling, false);
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
?>