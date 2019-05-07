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
    <div class="container-fluid h-100">
        <div class="row h-100">
            <form method="post" action="login.php" class="form-signin">
                <h1 class="h3 mb-3 font-weight-normal text-center">Login</h1>
                <label for="inputEmail" class="sr-only">Gebruikersnaam</label>
                <input type="text" name="gebruikersnaam" id="inputEmail" class="form-control" placeholder="Gebruikersnaam" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name="wachtwoord" id="inputPassword" class="form-control" placeholder="Wachtwoord" required>
                <div class="checkbox mb-3">
                    <label><input type="checkbox" value="remember-me"> Remember me</label>
                </div>
                <button class="btn btn-lg btn-primary btn-block bg-flame" type="submit" value="Login" name="loginKnop">Sign in</button>
            </form>
        </div>
    </div>

<?php include '../includes/footer.php' ?>
