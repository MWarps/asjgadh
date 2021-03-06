<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
geen problemen gevonden
*/
include 'includes/header.php';
// Controleerd of de gebruiker niet is ingelogd.
if (!isset($_SESSION['gebruikersnaam'])) {

    $error = false;
    // Kijk of de gebruikersnaam en wachtwoord zijn ingevoerd en of er op de login knop is gedrukt.
    if (isset($_POST['loginKnop'])) {
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $wachtwoord = $_POST['wachtwoord'];

        $gebruiker = haalGebruikerOp($gebruikersnaam);
        // Verificatie van de ingevoerde velden van de gebruiker
        if ($gebruikersnaam == $gebruiker['gebruikersnaam'] && $wachtwoord == password_verify($wachtwoord, $gebruiker['wachtwoord'])) {
            $_SESSION['gebruikersnaam'] = $gebruikersnaam;
            $_SESSION['status'] = 'login';
            $url = 'index.php';
            echo '<script language="javascript">window.location.href ="' . $url . '"</script>';

        } else {
            $error = true;
        }
    }


    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-4">
                <form class="needs-validation form-signin" novalidate method="post" action="login.php">
                    <h1 class="h3 mb-3 font-weight-normal text-center">Login</h1>
                    <?php

                    if ($error) {
                        echo '<div class="form-row">
                          <div class="alert alert-warning" role="alert">
                            <strong>Fout!</strong> Gebruikersnaam of wachtwoord klopt niet.
                            </div>
                          </div>
                        ';
                    }
                    ?>
                    <label for="inputEmail" class="sr-only">Gebruikersnaam</label>
                    <input type="text" name="gebruikersnaam" id="inputEmail" class="form-control mb-2"
                           placeholder="Gebruikersnaam" required>
                    <div class="invalid-feedback">
                        Voer een gebruikersnaam in.
                    </div>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" name="wachtwoord" id="inputPassword" class="form-control"
                           placeholder="Wachtwoord" required>
                    <div class="invalid-feedback">
                        Voer een wachtwoord in.
                    </div>
                    <a href="wachtwoordReset.php" class="register-link">Wachtwoord vergeten? Klik hier!</a>
                    <button class="btn btn-lg btn-block bg-flame" type="submit" value="loginKnop" id="loginKnop"
                            name="loginKnop">Inloggen
                    </button>
                    <a href="register.php" class="register-link">Nog geen account? Registreer hier!</a>
                </form>
            </div>
        </div>
    </div>
    <?php
} else {
    include 'includes/404error.php';
    unset($_SESSION['gebruikersnaam']);
}
include 'includes/footer.php';
?>
