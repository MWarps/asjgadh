<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
geen problemen gevonden
*/
include 'includes/header.php';
$gebruikersnaam = "";
if (checkBEHEERDER ($_SESSION['gebruikersnaam']) == true){     

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
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="h3 offset-2 mb-3 font-weight-normal text-center">Resultaten:</h1>
                <table class="table table-responsive">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">adress</th>
                        <th scope="col">brief</th>
                        <th scope="col">email</th>
                        <th scope="col">verzonden:</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        verificatiesVinden();
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div> <!--/.container-->
    <?php
}else{
    include 'includes/404error.php';
}
//include 'includes/footer-fixed.php'
?>
