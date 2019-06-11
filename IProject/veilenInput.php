<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
bestand is te groot voor de validator bij valideren in delen mist er een haakje dat in een ander deel zat
*/
include 'includes/header.php';
$VerkoperValidatie = false;

if (empty(gegevensIngevuldVerkoper($_SESSION['gebruikersnaam']))) {
    $VerkoperValidatie = true;
}
if (!empty(gegevensIngevuldVerkoper($_SESSION['gebruikersnaam']))) {
    $verkoper = gegevensIngevuldVerkoper($_SESSION['gebruikersnaam']);
    if ($verkoper['gevalideerd'] == 0) {
        $VerkoperValidatie = true;
    }
}

if (isset($_SESSION['gebruikersnaam'])) {
    if (isset($_GET['id'])) {
        $_SESSION['rubrieknr'] = $_GET['id'];
    }

    $uploadOk = 1;
    if (isset($_POST['Volgende'])) {
        $titel = $_POST['titel'];
        $beschrijving = $_POST['beschrijving'];
        $startbedrag = $_POST['startbedrag'];
        $betalingsmethode = $_POST['betalingsmethode'];
        $betalingsinstructie = $_POST['betalingsinstructie'];
        $verzendkosten = $_POST['verzendkosten'];
        $verzendinstructies = $_POST['verzendinstructies'];
        $plaats = $_POST['plaats'];
        $land = $_POST['rLand'];
        $looptijd = $_POST['looptijd'];


        // Alle inputvelden met verkoper in een array gezet
        $voorwerp = array($titel, $beschrijving, $startbedrag, $betalingsmethode,
            $betalingsinstructie, $plaats, $land, $looptijd, $verzendkosten,
            $verzendinstructies, $_SESSION['gebruikersnaam']);

        // Voorwerp toevoegen in database en voorwerpnr terughalen
        $voorwerpnr = VoegVoorwerpToe($voorwerp);
        $voorwerpnr = $voorwerpnr['voorwerpnr'];

        VoegVoorwerpAanRubriekToe($voorwerpnr, $_SESSION['rubrieknr']);
        // Foto1 uploaden naar server
        $target_dir = "upload/";

        $target_file = $target_dir . basename($_FILES["foto1"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $bestand_naam_db = strval("ea_1_" . $voorwerpnr . "." . $imageFileType);

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["foto1"]["tmp_name"]);
        if ($check !== false) {
            move_uploaded_file($_FILES["foto1"]["tmp_name"], $target_dir . $bestand_naam_db);
            VoegVoorwerpToeAanIllustratie($voorwerpnr, $bestand_naam_db);
        } else {
            $uploadOk = 0;
        }


// Foto2 uploaden naar server
        if ($_FILES["foto2"]["error"] != 4) {
            $target_file = $target_dir . basename($_FILES["foto2"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $bestand_naam_db = strval("ea_2_" . $voorwerpnr . "." . $imageFileType);

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["foto2"]["tmp_name"]);
            if ($check !== false) {
                move_uploaded_file($_FILES["foto2"]["tmp_name"], $target_dir . $bestand_naam_db);
                VoegVoorwerpToeAanIllustratie($voorwerpnr, $bestand_naam_db);
            } else {
                $uploadOk = 0;
            }
        }

        // Foto3 uploaden naar server
        if ($_FILES["foto3"]["error"] != 4) {
            $target_file = $target_dir . basename($_FILES["foto3"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $bestand_naam_db = strval("ea_3_" . $voorwerpnr . "." . $imageFileType);

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["foto3"]["tmp_name"]);
            if ($check !== false) {
                move_uploaded_file($_FILES["foto3"]["tmp_name"], $target_dir . $bestand_naam_db);
                VoegVoorwerpToeAanIllustratie($voorwerpnr, $bestand_naam_db);
            } else {
                $uploadOk = 0;
            }
        }

// Foto4 uploaden naar server  
        if ($_FILES["foto4"]["error"] != 4) {
            $target_file = $target_dir . basename($_FILES["foto4"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $bestand_naam_db = strval("ea_4_" . $voorwerpnr . "." . $imageFileType);

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["foto4"]["tmp_name"]);
            if ($check !== false) {
                move_uploaded_file($_FILES["foto4"]["tmp_name"], $target_dir . $bestand_naam_db);
                VoegVoorwerpToeAanIllustratie($voorwerpnr, $bestand_naam_db);
            } else {
                $uploadOk = 0;
            }
        }
        $_SESSION['status'] = 'voorwerp';

        echo '<script language="javascript">window.location.href ="index.php"</script>';
        exit();
    }

    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mt-2">
                <form class="needs-validation" novalidate action="veilenInput.php" method="POST"
                      enctype="multipart/form-data">
                    <h1 class="h3 mb-2 text-center "> Veiling starten </h1>
                    <p class=" mb-2 text-center "> Hier kunt u een voorwerp te koop aan bieden, vul alle onderstaande
                        velden in.</p>
                    <?php
                    if ($uploadOk == 0) {
                        echo '<div class="container">
                        <div class="h-100 row align-items-center">
                          <div class="col">
                              <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                                <strong>Foto is niet geupload</strong> Het geuploade bestand is geen foto.
                                <button type="button" class="close pt-0" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                          </div>
                        </div>
                      </div>';
                    }
                    ?>

                    <div class="form-group col-md-10">
                        <label for="inputTitel">Titel (Vul een titel in. Denk aan belangrijke eigenschappen zoals kleur,
                            merk of maat):</label>
                        <input type="text" name="titel" class="form-control" id="inputTitel"
                               pattern="[A-Za-z0-9]{1,40}" maxlength="100" placeholder="Titel"
                               value="<?php if ($_POST) {
                                   echo $_POST['titel'];
                               } ?>" required>
                        <div class="invalid-feedback">
                            Voer een geldige titel in, deze mag geen tekens bevatten.
                        </div>
                    </div>
                    <div class="form-group col-md-10">
                        <label for="beschrijving">Beschrijving:</label>
                        <input type="text" name="beschrijving" class="form-control" placeholder="Voer hier een beschrijving in in."
                                  pattern="[A-Za-z0-9 ]{1,50}" id="beschrijving" required>
                        <div class="invalid-feedback">
                            Voer een beschrijving in, deze mag geen tekens bevatten.
                        </div>
                    </div>

                    <div class="form-group col-md-6">

                        <div class="form-group">
                            <label for="exampleFormControlFile1">Voeg minimaal 1 afbeelding toe</label>
                            <input type="file" class="form-control-file" name="foto1" accept="image/*" id="foto1"
                                   required>
                            <div class="invalid-feedback">
                                Geef minmaal 1 foto mee.
                            </div>
                            <label for="exampleFormControlFile2">Afbeelding 2</label>
                            <input type="file" class="form-control-file" accept="image/*" name="foto2" id="foto2">
                            <label for="exampleFormControlFile3">Afbeelding 3</label>
                            <input type="file" class="form-control-file" accept="image/*" name="foto3" id="foto3">
                            <label for="exampleFormControlFile4">Afbeelding 4</label>
                            <input type="file" class="form-control-file" accept="image/*" name="foto4" id="foto4">
                        </div>
                    </div>


                    <div class="form-group col-md-4">
                        <label for="inputStartbedrag">Startbedrag in euro's</label>
                        
                        <input type="number" min="0" name="startbedrag" class="form-control" id="inputStartbedrag"
                               placeholder="€..." step="0.01" maxlength="5" value="<?php if ($_POST) {
                            echo $_POST['startbedrag'];
                        } ?>" required>
                        <div class="invalid-feedback">
                            Voer een geldig startbedrag in, dit getal moet hoger zijn dan 0.
                        </div>
                        
                    </div>
                    <div class="form-group col-md-8">
                        <label for="Textarea">Betalingsinstructies(optioneel):</label>
                        <textarea name="betalingsinstructie" class="form-control" placeholder="Voer hier uw bericht in."
                                  id="Textarea" rows="10"></textarea>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputVerzendBedrag">Verzendkosten</label>
                        
                        <input type="number" min="0" name="verzendkosten" class="form-control" id="inputVerzendBedrag"
                               placeholder="€..." step="0.01" maxlength="5"
                               pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,49}$" maxlength="5" value="<?php if ($_POST) {
                            echo $_POST['startbedrag'];
                        } ?>">

                    </div>
                    <div class="form-group col-md-8">
                        <label for="Textarea">Verzendinstructies(optioneel):</label>
                        <textarea name="verzendinstructies" class="form-control" placeholder="Voer hier uw bericht in."
                                  id="Textarea" rows="10"></textarea>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputBetalingsmethode">Gewenste betalingsmethode</label>
                        <select name="betalingsmethode" class="form-control" id="inputBetalingsmethode"
                                value="<?php if ($_POST) {
                                    echo $_POST['rBetalingsmethode'];
                                } ?>" required>
                            <option value="Contant"> Contant</option>
                            <option value="iDeal"> iDeal</option>
                            <option value="Paypal"> Paypal</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPlaats">Plaats</label>
                        <input type="text" name="plaats" class="form-control" id="inputPlaats" placeholder="Plaats"
                               pattern="[A-Za-z]*" maxlength="28"
                               value="<?php if (isset($_POST['rPlaats'])) echo $_POST['rPlaats']; ?>" required>
                        <div class="invalid-feedback">
                            Voer een plaats in.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <?php echo landen(); ?>
                    </div>

                    <div class="form-group col-md-6">
                        <p> looptijd: </p>
                        <!-- Group of default radios - option 1 -->
                        <div class="custom-control custom-radio">
                            <input type="radio" value="5" class="custom-control-input" id="defaultGroupExample1"
                                   name="looptijd" checked>
                            <label class="custom-control-label" for="defaultGroupExample1">5 dagen</label>
                        </div>

                        <!-- Group of default radios - option 2 -->
                        <div class="custom-control custom-radio">
                            <input type="radio" value="7" class="custom-control-input" id="defaultGroupExample2"
                                   name="looptijd">
                            <label class="custom-control-label" for="defaultGroupExample2">7 dagen</label>
                        </div>

                        <!-- Group of default radios - option 3 -->
                        <div class="custom-control custom-radio">
                            <input type="radio" value="10" class="custom-control-input" id="defaultGroupExample3"
                                   name="looptijd">
                            <label class="custom-control-label" for="defaultGroupExample3">10 dagen</label>
                        </div>
                    </div>


                    <div class="form-group col-md-6">
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
                    <div class="form-group col-md-6">
                        <button type="submit" name="Volgende" id="Volgende" class="btn bg-flame">
                            Volgende
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php
} else {
    include 'includes/404error.php';
}
include 'includes/footer.php';
?>

