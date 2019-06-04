<?php
include 'includes/header.php';
require_once 'core/dbconnection.php';

if(isset($_SESSION['gebruikersnaam'])) {

$verkoper = gegevensIngevuld($_SESSION['gebruikersnaam']);

if(!empty(gegevensIngevuld($_SESSION['gebruikersnaam']))) {
    if($verkoper[0]['gevalideerd'] == 1) {
        echo '<script language="javascript">window.location.href ="index.php"</script>';
    }
    else{
        echo '<script language="javascript">window.location.href ="verkoperValidatie.php"</script>';
    }
}



if (isset($_POST['rVolgende'])) {
    $bank = $_POST['bank'];
    $bankrekeningnr = $_POST['bankrekeningnr'];
    $creditcard = $_POST['creditcard'];
    $type = 'brief';

    $input = array($_SESSION['gebruikersnaam'], $bank, $bankrekeningnr, $creditcard);

    $mailVerstuurd = true;

    $gebruiker = HaalGebruikerOp($_SESSION['gebruikersnaam']);
    insertVerkoper($input);
    VerificatieCodeProcedure($gebruiker['email'], $type);
    $code = HaalVerficatiecodeOp($gebruiker['email'], $type);

    MaakVerkoperBrief($_SESSION['gebruikersnaam']);

    echo '<script language="javascript">window.location.href ="verkoperValidatie.php"</script>';
    exit();
}

?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header">
                    <h1>Beoordelinging van <?php $rating = HaalGebruikerOp();?></h1>
                    <div class="card-body">
                        <p>Beoordeel het contact met <?= $rating['gebruikersnaam']?> tijdens en na afloop van de veiling van <?=$rating['titel']?></p>
                        <div class="slidecontainer">
                            <input type="range" min="1" max="10" value="5" class="slider" id="myRange">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    }
    else {
        include 'includes/404error.php';
    }

    include 'includes/footer.php'; ?>
