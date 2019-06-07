<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
geen problemen gevonden
*/

// controleerd of de persoon is ingelogd beheerders rechten heeft 
include 'includes/header.php';
if (checkBEHEERDER ($_SESSION['gebruikersnaam']) == true){  
?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-4">
                <h1 class="h3 mb-3 font-weight-normal text-center">Beheerders omgeving</h1>
                <h2 class="h3 mb-3 font-weight-normal text-center">Toegestane acties:</h2>
                <ul class="list-group">
                    <a class="list-group-item list-group-item-action" href="overzichtGebruikers.php">Overzicht
                        gebruikers</a>
                    <a class="list-group-item list-group-item-action" href="overzichtVeilingen.php">Overzicht actieve
                        veilingen</a>
                    <a class="list-group-item list-group-item-action" href="verkoperVerificatieBrief.php">verkoper
                        verificatie brieven</a>
                </ul>
            </div>
        </div>
    </div>
    <?php
} else {
    include 'includes/404error.php';
}
include 'includes/footer.php'
?>