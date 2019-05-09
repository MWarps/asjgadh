<?php
session_start();

require_once '../core/dbconnection.php';
include '../includes/header.php';
include '../includes/functies.php';

$error = false;

if (isset($_POST['Volgende'])){
$Gebruikersnaam = $_POST['gebruikersnaam'];
$Veiligheidsvraag = $_POST['rGeheimV'];
$AntwoordVeiligheidsvraag = $_POST ['wGeheimA'];


$input = array($Gebruikersnaam, $Veiligheidsvraag, $AntwoordVeiligheidsvraag
               );

$GebruikerArray = haalGebruikerOp($Gebruikersnaam);

  if (empty($GebruikerArray['gebruikersnaam']) || $Veiligheidsvraag != $GebruikerArray['vraag'] || $Veiligheidsvraag != $GebruikerArray['antwoordtekst']){
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
                  <input type="text" class="form-control mb-2" name="gebruikersnaam" id="Gebruikersnaam" placeholder="Gebruikersnaam" required>
            <!-- hieronder wordt de veiliheidsvraag geselecteerd -->
<<<<<<< HEAD
                      <?php
                          echo resetVragen();
=======
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="selecteerVeiligheidsvraag">Selecteer je Veiligheidsvraag</label>
                    <select class="Veiliheidsvraag form-control">
                        <option selected>Selecteer</option> <!-- Standard in select menu -->
                        <?php 
                        vragenOphalen(); 
>>>>>>> master
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
<?php include '../includes/footer.php' ?>

<<<<<<< HEAD
<?php
=======
<?php 
//    $sqlinformatie = $dbh -> prepare(
//    "SELECT gebruikersnaam, vraag, antwoordtekst FROM Gebruiker WHERE gebruikersnaam = ':gebruikersnaamPHP' ");// einde prepared statement $sqlinformatie
//    $sqlWWreset = $dbh -> prepare (
//    "UPDATE Gebruiker SET wachtwoord where gebruikersnaam = ':gebruikersnaamPHP' "
//    )
//
//if (isset($_POST['wwReset'])){
//    $gebruikersnaamPHP = $_POST['gebruikersnaam'];
//    $veiligheidsvraag = $_POST['veiligheidsvraag'];
//    $antwoordVeiligheidsvraag = $_POST ['antwoordVeiligheidsvraag'];
//    $nwachtwoord1 = $_POST ['wachtwoord1'];
//    $nwachtwoord2 = $_POST['wachtwoord2'];
//
//    while ($data = $sqlinformatie-> fetch(PDO::FETCH_ASSOC) ){
//        $dbgebruikersnaam = $data['gebruikersnaam'];
//        $dbVvraag = $data['vraag'];
//        $dbVantwoord = $data['antwoordtekst'];
//        if ($gebruikersnaamPHP == $dbgebruikersnaam ){
//            echo '<h1> gebruikersnaam is correct, maar de gekozen veiligheidsvraag niet.</h1>';
//            if ($antwoordVeiligheidsvraag == $dbVvraag){
//                echo'<h1>de gebruikersnaam en de gekozen veiligheidsvraag is correct, maar het antwoord niet.</h1>';
//                if ($antwoordVeiligheidsvraag == $dbVantwoord){
//                    echo'<h1>de gebruikersnaam,veiighiedsvraag en het antwoord is correct. gegevens worden gewijzigd.</h1>';
//                    echo  '<h1> Het werkt</h1>';
//
//                }
//            }
//        }
//    }
//}// einde if isset
>>>>>>> master

?>
