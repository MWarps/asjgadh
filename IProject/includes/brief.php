<?php
function Brief($records) {
    $naam = ($records['voornaam'].' '.$records['achternaam']);
    $myfile = fopen("../brieven/".$naam.".txt", "x") or die("Unable to open file!");

    $txt = (
    "Mickey Mouse\n"
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
