<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
geen problemen gevonden
*/
include 'includes/header.php';
require_once 'core/dbconnection.php';

if (isset($_GET['verkoper'])) {
    $_SESSION['vekoper'] = $_GET['verkoper'];
}

if (isset($_POST['volgende'])) {
    $waarde = $_POST['waarde'];
    $_SESSION['status'] = 'recentie';
    updateRecentie($waarde, $_SESSION['vekoper']);
    unset($_SESSION['vekoper']);
    echo '<script language="javascript">window.location.href ="index.php"</script>';

}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header">
                    <h1>Beoordelinging van <?php echo $verkoper[0]['gebruikersnaam']; ?></h1>
                    <div class="card-body">
                        <p>Beoordeel de algemene ervaring met <?php echo $verkoper[0]['gebruikersnaam'] ?> tijdens en na
                            afloop van de veiling van: <strong> <?php echo $verkoper[1]['titel'] ?></strong></p>
                        <div class="icon-beoordeling">
                            <p><img src="assets/img/Boos.png"> <img src="assets/img/Blij.png" class="img-responsive pull-right"></p>
                        </div>
                        <form action="rating.php" method="POST">
                            <div class="slidecontainer">
                                <input type="range" min="1" max="10" value="5" name="waarde" class="slider"
                                       id="myRange">
                                <p>Beoordeling: <span id="demo"></span></p>
                            </div>
                            <button type="submit" name="volgende" class="btn bg-flame btn-lg">Volgende</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php


include 'includes/footer.php'; ?>
