<?php
include('../includes/header.php');
require_once('../core/dbconnection.php');
require('../includes/functies.php');

if (isset($_POST['loginKnop'])) {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];
    $loginKnop = $_POST['loginKnop'];

        try {
            $sqlSelect = $dbh->prepare("select gebruikersnaam, wachtwoord from
            Gebruiker where gebruikersnaam=:gebruikersnaam group by gebruikersnaam, wachtwoord");

            $sqlSelect->execute(
                array(
                    ':gebruikersnaam' => $gebruikersnaam,
                ));
            $records = $sqlSelect->fetch(PDO::FETCH_ASSOC);

            if (!$records) {
                echo 'Gebruikersnaam of Wachtwoord incorrect';
                header("Refresh: 2; url=login.php");
                die();
            }
            if (password_verify($wachtwoord, $records['wachtwoord'])) {
                $_SESSION['gebruikersnaam'] = $gebruikersnaam;
                header("refresh:0; url=index.php");
            } else {
                echo 'Gebruikersnaam of Wachtwoord incorrect';
                header("Refresh: 2; url=login.php");
                die();
            }

        } catch (PDOexception $e) {
            echo "er ging iets mis error: {$e->getMessage()}";
        }
    }


 ?>
    <div class="container-fluid">
        <div class="row">
            <form method="post" action="login.php" class="form-signin">
                <h1 class="h3 mb-3 mt-3 font-weight-normal text-center">Login</h1>
                <label for="inputEmail" class="sr-only">Gebruikersnaam</label>
                <input type="text" name="gebruikersnaam" id="inputEmail" class="form-control" placeholder="Gebruikersnaam" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name="wachtwoord" id="inputPassword" class="form-control" placeholder="Wachtwoord" required>
                <a href="register.php" class="register-link">Nog geen account? Registreer hier!</a>
                <button class="btn btn-lg btn-block bg-flame" type="submit" value="Login" name="loginKnop">Inloggen</button>
            </form>
        </div>
    </div>
    <div class="footercolor">
        <footer class="footer-login">
            <div class="container py-2">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Copyright</h5>
                        <small class="d-block mb-3 text-muted">&copy; Project Groep 34 / 2019</small>
                    </div>
                    <div class="col-md-6">
                        <h5>Over ons</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="#">Contact</a></li>
                            <li><a class="text-muted" href="#">Algemene voorwaardes</a></li>
                            <li><a class="text-muted" href="#">Privacy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
