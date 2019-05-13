<?php
function Brief($records) {
    $naam = ($records['voornaam'].' '.$records['achternaam']);
    $myfile = fopen("../brieven/".$naam.".txt", "x") or die("Unable to open file!");

    $aanhef = 'heer, mevrouw';

    if($records['geslacht'] = 'M') {
        $aanhef = 'heer';
    } else if($records['geslacht'] = 'V'){
        $aanhef = 'mevrouw';
    }

    $txt = (
    $naam."\n".$records['adresregel1']."\n".$records['adresregel2']."\n".$records['postcode']." ".$records['plaatsnaam']."\n\n\n
    Geachte ".$aanhef.",\n
    Bedankt voor uw aanvraag om verkoper te worden op EenmaalAndermaal. Uw verificatiecode is: \n".$records['verificatiecode']."\n
    De code is geldig tot: \n".$records['eindtijd']."\n U kunt de code invoeren op: \n /*webadress*/ \n
    Of via uw profiel -> Mijn account en dan verkoper worden. \n 
    Heeft u nog vragen of opmerkingen naar over het verificatieproces, neem dan contact op met ons via de contact pagina op de website. \n
    \n \n Met vriendelijke groet, \n \n EenmaalAndermaal \n Iproject34.icasites.nl"
    );
    fwrite($myfile, $txt);

    fclose($myfile);
}
/**
 * Created by PhpStorm.
 * User: yodas
 * Date: 09/05/2019
 * Time: 14:36
 */
