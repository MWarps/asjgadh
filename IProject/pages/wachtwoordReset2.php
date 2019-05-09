<?php
session_start();

require_once '../core/dbconnection.php';
include '../includes/header.php';
include '../includes/functies.php';

if(isset($_SESSION['reset'])){

$Validatie = false;

if (isset($_POST['veranderWachtwoord'])){
$nWachtwoord1 = $_POST ['nWachtwoord1'];

$Validatie = true;
unset($_SESSION['validatie']);
updateWachtwoord($_SESSION['gebruikersnaam']);

header("Refresh:5 ; url=index.php");
}

?>

<div class="container">
    <div class="offset-3 col-md-6 mt-4">
      <div class="jumbotron bg-dark text-white" style="padding: 2rem">
      <form class="needs-validation" novalidate action='wachtwoordReset2.php' method="post"
      oninput='nWachtwoord1.setCustomValidity(nWachtwoord1.value != nWachtwoord2.value ? "Passwords do not match." : "")'>
      <?php if($Validatie){
        echo '<div class="form-row">
                <div class="alert alert-success" role="alert">
                  <strong>U wachtwoord is gewijzigd</strong> U wordt doorgestuurd naar de hoofdpagina.
                  </div>
                </div>
              ';}
      ?>
            <h1 class="h3 mb-3 mt-3 font-weight-normal>">Wachtwoord resetten</h1>
            <!-- hieronder wordt het nieuwe wachtwoord gegeven (X2) -->
                    <label for="inputWachtwoord1">Nieuw wachtwoord</label>
                    <input type="password" name="nWachtwoord1" class="form-control" id="inputWachtwoord1"
                    pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Wachtwoord" required>
                    <div class="invalid-feedback">
                      Voer een wachtwoord in met minimaal 8 tekens, 1 kleine letter, 1 hoofdletter en 1 teken.
                    </div>

                    <label for="inputWachtwoord2">Herhaal nieuw wachtwoord</label>
                    <input type="password" name="nWachtwoord2" class="form-control" id="inputWachtwoord"
                    pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Wachtwoord" required>
                    <div class="invalid-feedback">
                      Voer hetzelfde wachtwoord in.
                    </div>
            <!-- hier wordt de reset button gemaakt. -->
                    <button  type="submit" value="veranderWachtwoord" id="veranderWachtwoord" name="veranderWachtwoord" class="btn bg-flame mt-3">Reset Wachtwoord</button>

        </form>
    </div>
  </div>
</div>

<?php
}

else {
  include '../includes/404error.php';
}
include '../includes/footer.php'; ?>
