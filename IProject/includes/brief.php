/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/

eerste validatie:
warnings:
- enkele = tekens in de if statements.

oplossingen:
- = in de if statements veranderd in ==

tweede validatie:
geen problemen gevonden
*/
<?php
function Brief($records) {
    $naam = ($records['voornaam'].' '.$records['achternaam']);
    //$myfile = fopen("".$naam.".txt", "x") or die("Unable to open file!");

    $aanhef = 'heer, mevrouw';

    if($records['geslacht'] == 'M') {
        $aanhef = 'heer';
    } else if($records['geslacht'] == 'V'){
        $aanhef = 'mevrouw';
    }

    $txt = array(
    "adress" => ($naam."\n".$records['adresregel1']."\n".$records['adresregel2']."\n".$records['postcode']." ".$records['plaatsnaam']),
    "brief" =>  ("Geachte ".$aanhef.",\n
    Bedankt voor uw aanvraag om verkoper te worden op EenmaalAndermaal. Uw verificatiecode is: \n".$records['verificatiecode']."\n
    De code is geldig tot: \n".$records['eindtijd']."\n via uw profiel -> Mijn account en dan verkoper worden. \n 
    Heeft u nog vragen of opmerkingen naar over het verificatieproces, neem dan contact op met ons via de contact pagina op de website. \n
    \n \n Met vriendelijke groet, \n \n EenmaalAndermaal \n Iproject34.icasites.nl"),
    "email" => $records['email']
    );
    //fwrite($myfile, $txt);

    //fclose($myfile);
    return $txt;
}

function ratingBrief($records){
    $naam = ($records['voornaam'].' '.$records['achternaam']);
    $myfile = fopen("../brieven/".$naam.".txt.","x") or die("Unable to open file!");

    $txt = (
    "Beste".$naam.",\n
    Uw transactie met".$records['gebruikersnaam']."is gelukt. Beoordeel het contact met".$records['gebruikersnaam']."tijdens en na afloop van de veiling".$records['objectitel']."\n
    hier".$records['rating']."
    \n \n Met vriendelijke groet, \n \n EenmaalAndermaal \n Iproject34.icasites.nl\""

    );
}
