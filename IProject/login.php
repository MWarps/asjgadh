<?php
include 'includes/header.php';

if (!isset($_SESSION['gebruikersnaam'])){
    $Validatie = false;
    $error = false;

    if (isset($_POST['loginKnop'])) {
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $wachtwoord = $_POST['wachtwoord'];

        $gebruiker = haalGebruikerOp($gebruikersnaam);

        if($gebruikersnaam == $gebruiker['gebruikersnaam'] && $wachtwoord == password_verify($wachtwoord,$gebruiker['wachtwoord'])){
            $_SESSION['gebruikersnaam'] = $gebruikersnaam;
            $Validatie = true;
            header("Refresh:5 ; url=index.php");
        } else {
            $error = true;
        }
    }
?>
<div class="container">
    <div class="row">
        <div class="offset-3 col-md-6 mt-4">
            <form class="needs-validation form-signin" novalidate method="post" action="login.php">
                <h1 class="h3 mb-3 font-weight-normal text-center">Login</h1>
                <?php if($Validatie){
        echo '<div class="form-row">
                          <div class="alert alert-success" role="alert">
                            <strong>U bent ingelogd!</strong> U wordt doorgestuurd naar de hoofdpagina.
                            </div>
                          </div>
                        ';}

    if($error){
        echo '<div class="form-row">
                          <div class="alert alert-warning" role="alert">
                            <strong>Fout!</strong> Gebruikersnaam of wachtwoord klopt niet.
                            </div>
                          </div>
                        ';}
                ?>
                <label for="inputEmail" class="sr-only">Gebruikersnaam</label>
                <input type="text" name="gebruikersnaam" id="inputEmail" class="form-control mb-2" placeholder="Gebruikersnaam" required>
                <div class="invalid-feedback">
                    Voer een gebruikersnaam in.
                </div>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name="wachtwoord" id="inputPassword" class="form-control" placeholder="Wachtwoord" required>
                <div class="invalid-feedback">
                    Voer een wachtwoord in.
                </div>
                <a href="wachtwoordReset.php" class="register-link">Wachtwoord vergeten? Klik hier!</a>
                <button class="btn btn-lg btn-block bg-flame" type="submit" value="loginKnop" id="loginKnop" name="loginKnop">Inloggen</button>
                <a href="register.php" class="register-link">Nog geen account? Registreer hier!</a>
            </form>
        </div>
    </div>
</div>
<?php
} else {
    include 'includes/404error.php';
    // unset($_SESSION['gebruikersnaam']);
}
include 'includes/footer-fixed.php';
?>

