<?php
include 'includes/header.php';
require_once 'includes/dbconnection.php';
require 'includes/functies.php';
$Gbestaat = False;
$Ebestaat = False;

if (isset($_POST['rVolgende'])) {
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
    $rPostcode = $_POST['rPostcode'];;
    $rLand = $_POST['rLand'];
    $rGeslacht = $_POST['rGeslacht'];
    $rVerkoper = 0;

    $input = array($rGebruikersnaam, $rVoornaam, $rAchternaam, $rWachtwoord,
    $rEmail, $rGeboorte, $rGeheimV, $rGeheimA, $rStraat, $rPlaats, $rPostcode,
    $rLand, $rVerkoper);

  if(!empty(bestaatGebruikersnaam($_POST['rGebruikersnaam']))) {
      $Gbestaat = True;
      }

  if(!empty(bestaatEmailadres($_POST['rEmail']))) {
      $Ebestaat = True;
      }

  if($Ebestaat == false && $Gbestaat == false){
    //header("Refresh: 1; url=validatie.php");
    $_SESSION['input'] = $input;
    $hashedWachtwoord = password_hash($rWachtwoord, PASSWORD_DEFAULT);

    try {
      // SQL insert statement
        $sqlInsert = $dbh->prepare("INSERT INTO Gebruiker (
           gebruikersnaam, voornaam, achternaam, geslacht, adresregel1,
           postcode, plaatsnaam, land, geboortedatum, email,
           wachtwoord, vraag, antwoordtekst, verkoper)
          values (
            :rGebruikersnaam, :rVoornaam, :rAchternaam, :rGeslacht, :rAdresregel1,
            :rPostcode, :rPlaatsnaam, :rLand, :rGeboortedatum, :rEmail,
            :rWachtwoord, :rVraag, :rAntwoordtekst, :rVerkoper)");

        $sqlInsert->execute(
            array(
                ':rGebruikersnaam' => $rGebruikersnaam,
                ':rVoornaam' => $rVoornaam,
                ':rAchternaam' => $rAchternaam,
                ':rGeslacht' => $rGeslacht,
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



?>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="offset-2 col-md-8">
                <form class="needs-validation" novalidate action='register.php' method="post"
                oninput='rHerhaalWachtwoord.setCustomValidity(rHerhaalWachtwoord.value != rWachtwoord.value ? "Passwords do not match." : "")'>
                    <h1 class="h3 mb-3 text-center">Registreer je hier!</h1>
                    <?php
                      if($Gbestaat){
                        echo  '<div class="form-row">
                                <div class="alert alert-warning" role="alert">
                                  <strong>De gebruikersnaam bestaat al!</strong>
                                </div>
                              </div>';
                      }
                      if($Ebestaat){
                        echo  '<div class="form-row">
                              <div class="alert alert-warning" role="alert">
                                  <strong>Het ingevoerde email adres wordt al gebruikt!</strong>
                                </div>
                               </div>';
                      }
                    ?>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label for="inputVoornaam">Voornaam</label>
                            <input type="text" name="rVoornaam" class="form-control" id="inputVoornaam"
                            placeholder="Voornaam" value="<?php if($_POST) { echo $_POST['rVoornaam'];} ?>" required>
                            <div class="invalid-feedback">
                              Voer een voornaam in.
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputTussennaam">Tussennaam</label>
                            <input type="text" name="rTussen" class="form-control" id="inputTussennaam" placeholder="Tussennaam"
                            value="<?php if($_POST) { echo $_POST['rTussen'];} ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputAchternaam">Achternaam</label>
                            <input type="text" name="rAchternaam" class="form-control" id="inputAchternaam" placeholder="Achternaam"
                            value="<?php if($_POST) { echo $_POST['rAchternaam'];} ?>" required>
                            <div class="invalid-feedback">
                              Typ een achternaam in.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputGebruikersNaam">Gebruikersnaam</label>
                            <input type="text" name="rGebruikersnaam" class="form-control" id="inputGebruikersNaam" placeholder="Gebruikersnaam"
                            value="<?php if($_POST) { echo $_POST['rGebruikersnaam'];} ?>" required>
                            <div class="invalid-feedback">
                              Voer een gebruikersnaam in.
                            </div>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="inputEmailR">Email</label>
                            <input type="email" name="rEmail" class="form-control" id="inputEmailR" placeholder="Email"
                            value="<?php if($_POST) { echo $_POST['rEmail'];} ?>" required>
                            <div class="invalid-feedback">
                              Voer een email adres in.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputWachtwoord">Wachtwoord</label>
                            <input type="password" name="rWachtwoord" class="form-control" id="inputWachtwoord" placeholder="Wachtwoord" required>
                            <div class="invalid-feedback">
                              Voer een wachtwoord in.
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputHerhaalWachtwoord">Herhaal Wachtwoord</label>
                            <input type="password" name="rHerhaalWachtwoord" class="form-control" id="inputHerhaalWachtwoord" placeholder="Herhaal Wachtwoord" required>
                            <div class="invalid-feedback">
                            Voer hetzelfde wachtwoord in.
                            </div>
                        </div>
                    </div>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                          <label for="inputGeboortedatum">Geboortedatum</label>
                          <input type="date" name="rGeboorte" class="form-control" id="inputGeboortedatum" placeholder="Geboortedatum"
                          value="<?php if($_POST) { echo $_POST['rGeboorte'];} ?>" required>
                            <div class="invalid-feedback">
                              Voer een geboortedatum in.
                            </div>
                          </div>
                              <div class="form-group col-md-2">
                              <label for="inputGeslacht">Geslacht</label>
                              <select name="rGeslacht" class="form-control" id="inputGeslacht" value="<?php if($_POST) { echo $_POST['rGeboorte'];} ?>" required>
                                <option> - </option>
                                <option> Man </option>
                                <option> Vrouw </option>
                              </select>
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
                          <input type="text" name="rGeheimA" class="form-control" id="inputGeheimAntwoord" placeholder="Geheim Antwoord"
                          value="<?php if (isset($_POST['rGeheimA'])) echo $_POST['rGeheimA']; ?>" required>
                          <div class="invalid-feedback">
                          Voer een antwoord in.
                          </div>
                      </div>
                  </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputStraatnaam">Straatnaam</label>
                            <input type="text" name="rStraat" class="form-control" id="inputStraatnaam" placeholder="Straatnaam"
                            value="<?php if (isset($_POST['rStraat'])) echo $_POST['rStraat']; ?>" required>
                            <div class="invalid-feedback">
                            Voer een straatnaam in.
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputHuisnummer">Huisnummer</label>
                            <input type="number" name="rHuisnr" class="form-control" id="inputHuisnummer" placeholder="Huisnummer"
                            value="<?php if (isset($_POST['rHuisnr'])) echo $_POST['rHuisnr']; ?>" required>
                            <div class="invalid-feedback">
                            Voer een huisnummer in.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPlaats">Postcode</label>
                            <input type="text" name="rPostcode" class="form-control" id="inputPlaats" placeholder="Postcode"
                            value="<?php if (isset($_POST['rPostcode'])) echo $_POST['rPostcode']; ?>"  required>
                            <div class="invalid-feedback">
                            Voer een postcode in.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPlaats">Plaats</label>
                            <input type="text" name="rPlaats" class="form-control" id="inputPlaats" placeholder="Plaats"
                            value="<?php if (isset($_POST['rPlaats'])) echo $_POST['rPlaats']; ?>" required>
                            <div class="invalid-feedback">
                            Voer een plaats in.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <?php  echo Landen(); ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="Check" required>
                            <label class="form-check-label" for="Check">
                              Ga akkoord met de algemene voorwaarden.
                            </label>
                            <div class="invalid-feedback">
                              U moet akkoord gaan met onze algemene voorwaarden voordat u kan registreren.
                            </div>
                          </div>
                        </div>
                    </div>
                    <button type="submit" name="rVolgende" class="btn btn-primary">
                      Volgende
                    </button>
                </form>
            </div>
        </div>

    <?php

     include 'includes/footer.php' ?>

    <?php include'includes/footer.php' ?>
