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
            <?php $rating = HaalGebruikerOp();?>
            <h1>Beoordeling</h1>
            <p>Beoordeel het contact met <?= $rating['gebruikersnaam']?> tijdens en na afloop van de veiling van <?=$rating['titel']?></p>
            <fieldset class="rating">
                <input type="radio" id="tien" name="rating" value="10" /><label class = "full" for="tien" title="Geweldig - 5 sterren"></label>
                <input type="radio" id="negen" name="rating" value="9" /><label class="half" for="negen" title="Pretty good - 4.5 stars"></label>
                <input type="radio" id="acht" name="rating" value="8" /><label class = "full" for="acht" title="Goed - 4 stars"></label>
                <input type="radio" id="zeven" name="rating" value="7" /><label class="half" for="seven" title="Meh - 3.5 stars"></label>
                <input type="radio" id="zes" name="rating" value="6" /><label class = "full" for="zes" title="Meh - 3 stars"></label>
                <input type="radio" id="vijf" name="rating" value="5" /><label class="half" for="vijf" title="Kinda bad - 2.5 stars"></label>
                <input type="radio" id="vier" name="rating" value="4" /><label class = "full" for="vier" title="Kinda bad - 2 stars"></label>
                <input type="radio" id="drie" name="rating" value="3" /><label class="half" for="drie" title="Meh - 1.5 stars"></label>
                <input type="radio" id="twee" name="rating" value="2" /><label class = "full" for="twee" title="Sucks big time - 1 star"></label>
                <input type="radio" id="een" name="rating" value="1" /><label class="half" for="een" title="Sucks big time - 0.5 stars"></label>
            </fieldset>
        </div>
    </div>


    <?php
    }
    else {
        include 'includes/404error.php';
    }

    include 'includes/footer.php'; ?>
