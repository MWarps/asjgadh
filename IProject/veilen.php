<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
geen problemen gevonden
*/
include 'includes/header.php';
$pagina = 'veilen.php';
$melding = false;
$VerkoperValidatie = false;

if (empty(gegevensIngevuldVerkoper($_SESSION['gebruikersnaam']))) {
    $VerkoperValidatie = true;
}
if (!empty(gegevensIngevuldVerkoper($_SESSION['gebruikersnaam']))) {
    $verkoper = gegevensIngevuldVerkoper($_SESSION['gebruikersnaam']);
    if ($verkoper['gevalideerd'] == 0) {
        $VerkoperValidatie = true;
    }
}

if (isset($_SESSION['gebruikersnaam']) && $VerkoperValidatie == false) {

    if (!isset($_SESSION['catogorieVeilen'])) {
        $_SESSION['catogorieVeilen'] = array("Home" => "-1");
    }

    if (isset($_GET['id'])) {
        $_SESSION['catogorie']['id'] = $_GET['id'];
    }

    if (isset($_POST['volgende'])) {
        $melding = true;
    }

    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form class="needs-validation" novalidate action='veilen.php' method="post">
                    <h1 class="h3 my-4 text-center "> Kies een rubriek! </h1>
                    <p>Kies een rubriek om verder te gaan met het veilen van uw product.</p>
                    <?php
                    if ($melding) {
                        echo '<div class="form-row">
                                <div class="alert alert-warning" role="alert">
                                    <strong>Kies een subrubriek!</strong>
                                </div>
                          </div>';
                    }
                    ?>
                    <div class="form-row">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <?php catogorieSoort($pagina); ?>
                            </ol>
                        </nav>
                        <div class="card bg-light card-breedte">
                            <div class="card-header bg-flame text-white text-uppercase"><i class="fa fa-list"></i>
                                categorie&euml;n
                            </div>
                            <?php DirectorieVindenVeilen(); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
} else {
    include 'includes/404error.php';
}
include 'includes/footer.php';
?>

