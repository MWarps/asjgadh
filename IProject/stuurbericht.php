<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
geen problemen gevonden
*/
include 'includes/header.php';
if (isset($_SESSION['gebruikersnaam']) && isset($_GET['id'])) {

    $Verstuurd = false;

    $_SESSION['id'] = HaalGebruikerOp($_GET['id']);

    $gebruiker = HaalGebruikerOp($_SESSION['gebruikersnaam']);

    if (isset($_POST['Volgende'])) {
        $Verstuurd = true;
        $titel = $_POST['titel'];
        $bericht = $_POST['bericht'];

        stuurbericht($titel, $bericht, $gebruiker, $_SESSION['id']);

    }

    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-4">
                <form class="needs-validation" novalidate action="stuurbericht.php?id=<?php echo $_GET['id'] ?>"
                      method="POST">
                    <h1 class="h3 mb-3 text-center">Stuur een bericht!</h1>
                    <?php
                    if ($Verstuurd) {
                        echo '<div class="form-row">
                          <div class="alert alert-success" role="alert">
                            <strong>Het bericht is verstuurd!</strong>
                          </div>
                         </div>';
                    }
                    ?>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="inputTitel">Titel:</label>
                            <input type="text" name="titel" class="form-control" id="inputTitel" placeholder="Titel"
                                   required>
                            <div class="invalid-feedback">
                                Voer een titel in.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="Textarea">Bericht:</label>
                            <textarea name="bericht" class="form-control" placeholder="Voer hier uw bericht in."
                                      id="Textarea" rows="10" required></textarea>
                            <div class="invalid-feedback">
                                Voer een bericht in.
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="Volgende" id="Volgende" class="btn bg-flame">
                        Stuur bericht
                    </button>
                </form>
            </div>
        </div>
    </div>


    <?php
} else {
    echo '<script language="javascript">window.location.href ="login.php"</script>';
    exit();
}
include 'includes/footer.php';
?>
