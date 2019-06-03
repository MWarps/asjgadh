<?php
echo ('php runt');
require '../includes/functies.php';
$klantteller = 0;
$botteller = 0;
try {
    require ('dbconnection.php');
    $sluitVeiling = $dbh -> prepare(' update Voorwerp set veilinggesloten = 1  where voorwerpnr = :voorwerpnr ');

    $haalVeilingenOp = $dbh -> prepare(' select * from Voorwerp V, Gebruiker G where  G.gebruikersnaam = V.verkoper and G.email not like %asjgadh% ');
    $botVeiling = $dbh -> prepare(' select * from Voorwerp V, Gebruiker G where  G.gebruikersnaam = V.verkoper and G.email  like asjgadh% ');

    //$haalVeilingenOp -> execute();
    $botVeiling -> execute();

    //$klanten =  $haalVeilingenOp = $sqlSelect->fetch(PDO::FETCH_ASSOC);
    $bots = $botVeiling ->fetch(PDO::FETCH_ASSOC);

    foreach ($bots as bot){
        echo('foreach active');
        if ((date("d.m.Y H:i", strtotime($bot[teller]['looptijdeindedagtijdstip'])) ) =< date("d.m.Y H:i")){
                echo ('timecheck if-statement active');
                $sluitVeiling -> execute( array(':voorwerpnr' => $bot[teller]['voorwerpnr'] ));
                $teller ++; // moet laatste regel zijn.
            }else{
                echo ('timecheck if-statement ELSE active');
            }
            }

            } catch {

            }
?>