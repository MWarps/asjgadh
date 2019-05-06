<?php
include '../includes/header.php';
require_once '../core/dbconnection.php';
require '../includes/functies.php';

if (isset($_POST['registreren'])) {
    $rGebruikersnaam = $_POST['rGebruikersnaam'];
    $rVoornaam = $_POST['rVoornaam'];
    $rAchternaam = $_POST['rTussen'] . ' ' . $_POST['rAchternaam'];
    $rWachtwoord = $_POST['rWachtwoord'];
    $rHerhaalWachtwoord = $_POST['rHerhaalWachtwoord'];
    $rEmail = $_POST['rEmail'];
    $rGeboorte = $_POST['rGeboorte'];
    $rGeheimV = (int)$_POST['rGeheimV'];
    $rGeheimA = $_POST['rGeheimA'];
    $rStraat = $_POST['rStraat'] . ' ' . $_POST['rHuisnr'];
    $rPlaats = $_POST['rPlaats'];
    $Verkoper = 0;
    $Postcode = "4399BC";
    $Land = "Nederland";

    // er wordt gecontroleerd of de gebruikersnaam al bestaat
    if (!empty(bestaatGebruikersnaam($rGebruikersnaam))) {
        echo 'Gebruikersnaam bestaat al';
        header("Refresh: 2; url=register.php");
        die();
    }

    else {
      /*
      $code = rand(1000,9999);
      $foutInvoer = 0;
      verstuur mail
      popup verficatie waar verficatie code in moet worden ingetoetst
      if (isset($_POST['registreren'])){
        if ($code == $_POST['ingevoerdecode']){

      }
      else{ $foutInvoer++;
      echo 'foute invoer probeer opnieuw';

*/

      // wachtwoord word gehashed
        $hashedWachtwoord = password_hash($rWachtwoord, PASSWORD_DEFAULT);

        try {
          // SQL insert statement
            $sqlInsert = $dbh->prepare("INSERT INTO Gebruiker (
               gebruikersnaam, voornaam, achternaam, adresregel1,
               postcode, plaatsnaam, land, geboortedatum, email,
               wachtwoord, vraag, antwoordtekst, verkoper)
              values (
                :rGebruikersnaam, :rVoornaam, :rAchternaam, :rAdresregel1,
                :rPostcode, :rPlaatsnaam, :rLand, :rGeboortedatum, :rEmail,
                :rWachtwoord, :rVraag, :rAntwoordtekst, :rVerkoper)");

            $sqlInsert->execute(
                array(
                    ':rGebruikersnaam' => $rGebruikersnaam,
                    ':rVoornaam' => $rVoornaam,
                    ':rAchternaam' => $rAchternaam,
                    ':rAdresregel1' => $rStraat,
                    ':rPostcode' => $Postcode,
                    ':rPlaatsnaam' => $rPlaats,
                    ':rLand' => $Land,
                    ':rGeboortedatum' => $rGeboorte,
                    ':rEmail' => $rEmail,
                    ':rWachtwoord' => $hashedWachtwoord,
                    ':rVraag' => $rGeheimV,
                    ':rAntwoordtekst' => $rGeheimA,
                    ':rVerkoper' => $Verkoper

                ));
        } catch (PDOexception $e) {
            echo "er ging iets mis {$e->getMessage()}";
        }


    }
}
  /*  <?php if($_POST) {  echo $_POST['voornaam']; } ?> */

?>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="offset-2 col-md-8">
                <form action='register.php' method="post">
                    <h1 class="h3 mb-3 text-center">Registreer je hier!</h1>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputVoornaam">Voornaam</label>
                            <input type="text" name="rVoornaam" class="form-control" id="inputVoornaam" placeholder="Voornaam">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputTussennaam">Tussennaam</label>
                            <input type="text" name="rTussen" class="form-control" id="inputTussennaam" placeholder="Tussennaam">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputAchternaam">Achternaam</label>
                            <input type="text" name="rAchternaam" class="form-control" id="inputAchternaam" placeholder="Achternaam">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputGebruikersNaam">Gebruikersnaam</label>
                            <input type="text" name="rGebruikersnaam" class="form-control" id="inputGebruikersNaam" placeholder="Gebruikersnaam">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="inputEmailR">Email</label>
                            <input type="email" name="rEmail" class="form-control" id="inputEmailR" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputWachtwoord">Wachtwoord</label>
                            <input type="password" name="rWachtwoord" class="form-control" id="inputWachtwoord" name='pas1' placeholder="Wachtwoord">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputHerhaalWachtwoord">Herhaal Wachtwoord</label>
                            <input type="password" name="rHerhaalWachtwoord" class="form-control" id="inputHerhaalWachtwoord" name='pas2' placeholder="Herhaal Wachtwoord">
                        </div>
                    </div>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                          <label for="inputGeboortedatum">Geboortedatum</label>
                          <input type="date" name="rGeboorte" class="form-control" id="inputGeboortedatum" placeholder="Geboortedatum">
                      </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                      <?php  echo resetVragen(); ?>
                      </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="inputGeheimAntwoord">Geheim Antwoord</label>
                          <input type="text" name="rGeheimA" class="form-control" id="inputGeheimAntwoord" placeholder="Geheim Antwoord">
                      </div>
                  </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputStraatnaam">Straatnaam</label>
                            <input type="text" name="rStraat" class="form-control" id="inputStraatnaam" placeholder="Straatnaam">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputHuisnummer">Huisnummer</label>
                            <input type="text" name="rHuisnr" class="form-control" id="inputHuisnummer" placeholder="Huisnummer">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPlaats">Plaats</label>
                            <input type="text" name="rPlaats" class="form-control" id="inputPlaats" placeholder="Plaats">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck">
                                <label class="form-check-label" for="gridCheck">Algemene voorwaarden</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" value="registreren" name="registreren" class="btn btn-primary">Registreren</button>
                </form>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php' ?>
