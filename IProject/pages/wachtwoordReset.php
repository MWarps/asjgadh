<?php
session_start();

require_once '../core/dbconnection.php';
include '../includes/header.php';
include '../includes/functies.php';

if(isset($_SESSION['gebruikersnaam'])){

$error = false;

if (isset($_POST['Volgende'])){
$Gebruikersnaam = $_POST['gebruikersnaam'];
$Veiligheidsvraag = $_POST['rGeheimV'];
$AntwoordVeiligheidsvraag = $_POST ['wGeheimA'];


$input = array($Gebruikersnaam, $Veiligheidsvraag, $AntwoordVeiligheidsvraag);

$GebruikerArray = haalGebruikerOp($Gebruikersnaam);
print_r($GebruikerArray);

  if (empty($GebruikerArray['gebruikersnaam']) || $Veiligheidsvraag != $GebruikerArray['vraag'] || $Veiligheidsvraag != $GebruikerArray['antwoordtekst'] ){
  /**/
    $error = true;
  }
  else{
    $_SESSION['reset'] = true;
    header("Location: wachtwoordReset2.php");
  }
}
?>

<div class="container">
    <div class="offset-3 col-md-6 mt-4">
      <div class="jumbotron bg-dark text-white" style="padding: 2rem">
      <form class="needs-validation" novalidate action='wachtwoordReset.php' method="post">
        <?php if ($error){
          echo '<div class="form-row">
                  <div class="alert alert-warning" role="alert">
                    <strong> FOUT! </strong> De gebruikersnaam, veiligheidsvraag of veiligheidsantwoord is komen niet overeen.
                    </div>
                  </div>'; }
          ?>
            <h1 class="h3 mb-3 mt-3 font-weight-normal>">Wachtwoord resetten</h1>
            <!-- hieronder wordt de tekst en invulveld voor de gebruikersnaam gemaakt -->
                  <label for="inputGebruikersnaam">Gebruikersnaam</label>
                  <input type="text" class="form-control mb-2" value="<?php echo $_SESSION['gebruikersnaam']; ?>" name="gebruikersnaam" id="gebruikersnaam" placeholder="Gebruikersnaam" required>
            <!-- hieronder wordt de veiliheidsvraag geselecteerd -->
                      <?php
                          echo resetVragen();
                          ?>
            <!-- hieronder wordt de veiliheidsvraag beantwoord -->
                    <label for="antwoordVeiligheidsvraag">Antwoord op veiligheidsvraag</label>
                    <input type="text" class="form-control mb-2" name="wGeheimA" id="antwoordVeiligheidsvraag" placeholder="Antwoord" required>
            <!-- hier wordt de reset button gemaakt. -->
                    <button  type="submit" name="Volgende" class="btn bg-flame mt-2">Reset Wachtwoord</button>
        </form>
      </div>
    </div>
</div>

<?php }
else {
  include '../includes/404error.php';
}
include '../includes/footer.php' ?>
