/**
* Created by PhpStorm.
* User: Merlijn Warps
* Date: 28/05/2019
* Time: 10:12
*/
<?php
include 'includes/header.php';
$gebruikersnaam = "";
if (checkBEHEERDER ($_SESSION['gebruikersnaam']) == true){     // veranderen naar admin variabel.
    if (isset($_POST['zoeken'])){
        $gebruikersnaam = "";
        $gebruikersnaam = $_POST['zoekopdracht'];
    }

    if (isset( $_GET['email'])){
        verificatieVerzonden($_GET['email']);
    }
    ?>
    <div class="container">

    <?php
    $verkopers = getWannabeVerkopers();
    $arrlength = count($verkopers);

    for($stap = 0; $stap < $arrlength; $stap++) {
        $record = maakVerkoperBrief($verkopers[$stap]);
        echo '<div class="row">
            <div class="col-2">
        '.$record['adress'].'
        </div>
            <div class="col-8">
        '.$record['brief'].'
        </div>
            <div class="col-1">
        '.$record['email'].'
        </div>
            <div class="col-1">
        <a class="btn btn-primary" href="hrefverkoperVerificatieBrief.php?email='.$record['email'].'" role="button">verzonden</a>
        </div>
        </div>';
    }
    ?>
    </div>
    <?php
}else{
    include 'includes/404error.php';
}
//include 'includes/footer-fixed.php'
?>
