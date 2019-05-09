<?php
session_start();

require_once '../core/dbconnection.php';
include '../includes/header.php';
include '../includes/functies.php';


if (isset($_POST['VeranderWachtwoord'])){
$nWachtwoord1 = $_POST ['nWachtwoord1'];

$input = array($Gebruikersnaam)




}
?>

<div class="container">
    <div class="offset-md-3">
      <div class="jumbotron bg-dark text-white" style="padding: 2rem">
      <form class="needs-validation" novalidate action='wachtwoordReset.php' method="post"
      oninput='nWachtwoord1.setCustomValidity(nWachtwoord1.value != nWachtwoord2.value ? "Passwords do not match." : "")'>
            <h1 class="h3 mb-3 mt-3 font-weight-normal>">Wachtwoord resetten</h1>
            <!-- hieronder wordt het nieuwe wachtwoord gegeven (X2) -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputWachtwoord1">Nieuw wachtwoord</label>
                    <input type="password" name="nWachtwoord1" class="form-control" id="inputWachtwoord1"
                    pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Wachtwoord" required>
                    <div class="invalid-feedback">
                      Voer een wachtwoord in met minimaal 8 tekens, 1 kleine letter, 1 hoofdletter en 1 teken.
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputWachtwoord2">Herhaal nieuw wachtwoord</label>
                    <input type="password" name="nWachtwoord2" class="form-control" id="inputWachtwoord"
                    pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Wachtwoord" required>
                    <div class="invalid-feedback">
                      Voer een wachtwoord in met minimaal 8 tekens, 1 kleine letter, 1 hoofdletter en 1 teken.
                    </div>
                </div>
            </div>
            <!-- hier wordt de reset button gemaakt. -->
            <div class="offset-md-2">
                <div class="form-row">
                    <button  type="submit" value="VeranderWachtwoord" name="veranderWachtwoord" class="btn bg-flame">Reset Wachtwoord</button>
                </div>
            </div>
        </form>
    </div>
  </div>
</div>

<?php include '../includes/footer.php' ?>
