<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
eerste validatie:
warings:
- een rij heeft dubbele ;

oplossingen:
- een van de ; weggehaald

tweede validatie
geen problemen gevonden
*/
include 'includes/header.php';
if(empty($_SESSION['gebruikersnaam'])){

if (isset($_GET['id']) || isset($_POST['rVolgende'])) {
$Gbestaat = False;
if (isset($_GET['id'])) {
  $_SESSION['validatie'] = haalCodeOp($_GET['id']);
}    

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
        $rAdres1 = $_POST['rStraat'] . ' ' . $_POST['rHuisnr'];
        $rAdres2 = $_POST['rStraat1'] . ' ' . $_POST['rHuisnr1'];
        $rPlaats = $_POST['rPlaats'];
        $rPostcode = $_POST['rPostcode'];
        $rLand = $_POST['rLand'];
        $rGeslacht = $_POST['rGeslacht'];
        
    $input = array($rGebruikersnaam, $rVoornaam, $rAchternaam, $rGeslacht, $rWachtwoord,
                   $rAdres1, $rAdres2, $rPostcode, $rPlaats, $rLand, $rGeboorte, $rEmail,
                   $rGeheimV, $rGeheimA);
                       
    array_push($input, 0);
    
    $gebruikersnaam = bestaatGebruikersnaam($rGebruikersnaam);
   // controleert of gebruikersnaam bestaat
  if(isset($gebruikersnaam['gebruikersnaam'])) {
      $Gbestaat = True;
      }

        // controleert of er geen error's zijn
        if ($Gbestaat == false) {
            $_SESSION['gebruikersnaam'] = $rGebruikersnaam;
            $_SESSION['status'] = 'registreren';
            InsertGebruiker($input);
            deleteVerificatieRij($_SESSION['validatie']['email'], $_SESSION['validatie']['type']);

            unset($_SESSION['validatie']);

            echo '<script language="javascript">window.location.href ="index.php"</script>';
            exit();
        }
    }

    ?>
    <div class="container-fluid h-100">
        <div class="row h-100 justify-content-center">
            <div class="col-md-8">
                <form class="needs-validation" novalidate action="registerInput.php" method="POST"
                      oninput='rHerhaalWachtwoord.setCustomValidity(rHerhaalWachtwoord.value != rWachtwoord.value ? "Passwords do not match." : "")'>
                    <h1 class="h3 mb-3 text-center">Registreer je hier!</h1>
                    <?php
                    if ($Gbestaat) {
                        echo '<div class="form-row">
                                <div class="alert alert-warning" role="alert">
                                  <strong>De gebruikersnaam bestaat al!</strong>
                                </div>
                               </div>';
                    }

                    ?>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputVoornaam">Voornaam</label>
                            <input type="text" name="rVoornaam" class="form-control" id="inputVoornaam"
                                   pattern="[a-zA-Z]*" maxlength="50" placeholder="Voornaam" value="<?php if ($_POST) {
                                echo $_POST['rVoornaam'];
                            } ?>" required>
                            <div class="invalid-feedback">
                                Voer een voornaam in.
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputTussennaam">Tussennaam</label>
                            <input type="text" name="rTussen" class="form-control" id="inputTussennaam"
                                   placeholder="Tussennaam"
                                   pattern="[A-Za-z]*" maxlength="10" value="<?php if ($_POST) {
                                echo $_POST['rTussen'];
                            } ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputAchternaam">Achternaam</label>
                            <input type="text" name="rAchternaam" class="form-control" id="inputAchternaam"
                                   placeholder="Achternaam"
                                   pattern="[A-Za-z]*" maxlength="41" value="<?php if ($_POST) {
                                echo $_POST['rAchternaam'];
                            } ?>" required>
                            <div class="invalid-feedback">
                                Typ een achternaam in.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputGebruikersNaam">Gebruikersnaam</label>
                            <input type="text" name="rGebruikersnaam" class="form-control" id="inputGebruikersNaam"
                                   placeholder="Gebruikersnaam"
                                   pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,49}$" maxlength="50" value="<?php if ($_POST) {
                                echo $_POST['rGebruikersnaam'];
                            } ?>" required>
                            <div class="invalid-feedback">
                                Voer een gebruikersnaam in.
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="rEmail">Email</label>
                            <input type="text" name="rEmail" class="form-control" id="rEmail"
                                   value="<?php echo $_SESSION['validatie']['email']; ?>"
                                   placeholder="<?php echo $email['email']; ?>"
                                   readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputWachtwoord">Wachtwoord</label>
                            <input type="password" name="rWachtwoord" class="form-control" id="inputWachtwoord"
                                   pattern="(?=^.{7,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                                   placeholder="Wachtwoord" required>
                            <div class="invalid-feedback">
                                Voer een wachtwoord in met minimaal 7 tekens, 1 kleine letter, 1 hoofdletter en 1 teken.
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputHerhaalWachtwoord">Herhaal Wachtwoord</label>
                            <input type="password" name="rHerhaalWachtwoord" class="form-control"
                                   id="inputHerhaalWachtwoord"
                                   pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                                   placeholder="Herhaal Wachtwoord" required>
                            <div class="invalid-feedback">
                                Voer hetzelfde wachtwoord in.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputGeboortedatum">Geboortedatum</label>
                            <input type="date" name="rGeboorte" class="form-control" id="inputGeboortedatum"
                                   placeholder="Geboortedatum"
                                   max="<?php echo date('Y-m-d'); ?>"
                                   min="<?php echo date('Y-m-d', strtotime("-120 year", time())); ?>"
                                   value="<?php if ($_POST) {
                                       echo $_POST['rGeboorte'];
                                   } ?>" required>
                            <div class="invalid-feedback">
                                Voer een geboortedatum in.
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputGeslacht">Geslacht</label>
                            <select name="rGeslacht" class="form-control" id="inputGeslacht" value="<?php if ($_POST) {
                                echo $_POST['rGeboorte'];
                            } ?>" required>
                                <option value="X"> -</option>
                                <option value="M"> Man</option>
                                <option value="F"> Vrouw</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <?php echo resetVragen(); ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputGeheimAntwoord">Geheim Antwoord</label>
                            <input type="text" name="rGeheimA" class="form-control" id="inputGeheimAntwoord"
                                   placeholder="Geheim Antwoord"
                                   pattern="[A-Za-z0-9]*" maxlength="50"
                                   value="<?php if (isset($_POST['rGeheimA'])) echo $_POST['rGeheimA']; ?>" required>
                            <div class="invalid-feedback">
                                Voer een antwoord in.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputStraatnaam">Adres 1</label>
                            <input type="text" name="rStraat" class="form-control" id="inputStraatnaam"
                                   placeholder="adres"
                                   pattern="[A-Za-z0-9]*" maxlength="65"
                                   value="<?php if (isset($_POST['rStraat'])) echo $_POST['rStraat']; ?>" required>
                            <div class="invalid-feedback">
                                Voer een adres in.
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputHuisnummer">Huisnr 1</label>
                            <input type="text" name="rHuisnr" class="form-control" id="inputHuisnummer"
                                   placeholder="Huisnummer"
                                   pattern="[A-Za-z0-9]*" maxlength="6"
                                   value="<?php if (isset($_POST['rHuisnr'])) echo $_POST['rHuisnr']; ?>" min="1"
                                   required>
                            <div class="invalid-feedback">
                                Voer een huisnummer in.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputStraatnaam1">Adres 2 (optioneel)</label>
                            <input type="text" name="rStraat1" class="form-control" id="inputStraatnaam1"
                                   placeholder="adres"
                                   pattern="[A-Za-z0-9]*" maxlength="65"
                                   value="<?php if (isset($_POST['rStraat1'])) echo $_POST['rStraat1']; ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputHuisnummer1">(optioneel)</label>
                            <input type="text" name="rHuisnr1" class="form-control" id="inputHuisnummer" min="1"
                                   placeholder="Huisnummer"
                                   pattern="[A-Za-z0-9]*" maxlength="6"
                                   value="<?php if (isset($_POST['rHuisnr1'])) echo $_POST['rHuisnr1']; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPlaats">Postcode</label>
                            <input type="text" name="rPostcode" class="form-control" id="inputPlaats"
                                   placeholder="Postcode"
                                   pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}"
                                   value="<?php if (isset($_POST['rPostcode'])) echo $_POST['rPostcode']; ?>"
                                   maxlength="7" required>
                            <div class="invalid-feedback">
                                Voer een postcode in.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPlaats">Plaats</label>
                            <input type="text" name="rPlaats" class="form-control" id="inputPlaats" placeholder="Plaats"
                                   pattern="[A-Za-z]*" maxlength="28"
                                   value="<?php if (isset($_POST['rPlaats'])) echo $_POST['rPlaats']; ?>" required>
                            <div class="invalid-feedback">
                                Voer een plaats in.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <?php echo landen(); ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <div class="form-check">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" value="" id="defaultUnchecked"
                                           required>
                                    <label class="custom-control-label" for="defaultUnchecked">
                                        Ga akkoord met de algemene voorwaarden.
                                    </label>
                                    <div class="invalid-feedback">
                                        U moet akkoord gaan met onze algemene voorwaarden voordat u kan registreren.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row text-center">
                        <button type="submit" name="rVolgende" id="rVolgende" class="btn bg-flame text-center">
                            Volgende
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
}} else {
    include 'includes/404error.php';

}

include 'includes/footer.php' ?>
