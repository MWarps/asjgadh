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
        <div class="row justify-content-center">
            <div class="col-md-6 mt-4">
                <h1 class="h3 mb-3 font-weight-normal text-center">Beheerders omgeving</h1>
                <h2 class="h3 mb-3 font-weight-normal text-center">Toegestane acties:</h2>
                <ul class="list-group">
                    <a class="list-group-item list-group-item-action" href="beheerder.php">Terug naar overzicht</a>
                    <a class="list-group-item list-group-item-action" href="overzichtVeilingen.php">Overzicht actieve veilingen</a>
                    <a class="list-group-item list-group-item-action" href="verkoperVerificatieBrief.php">verkoper verificatie brieven</a>
                </ul>
            </div>
        </div><!--/row-->
        <form class="needs-validation" novalidate action='overzichtGebruikers.php' method="post">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <h1 class="h3 mb-3 font-weight-normal text-center">Gebruikers zoeken</h1>
                    <div class="input-group mb-6">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="zoekopdracht" >Gebruikersnaam:</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Gebruikersnaam" aria-label="gebruikersnaam" aria-describedby="basic-addon1"name="zoekopdracht">
                        <button class="btn btn-primary" type="submit" value="zoeken" id="zoeken" name="zoeken">Zoeken</button>
                    </div>
                </div>
            </div><!--/row-->
        </form>

    <?php
    $verkopers = getWannabeVerkopers();
    $arrlength = count($verkopers);

    for($stap = 0; $stap < $arrlength; $stap++) {
        $record = maakVerkoperBrief($verkopers[$stap]);
        echo '
            <div class="row">
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