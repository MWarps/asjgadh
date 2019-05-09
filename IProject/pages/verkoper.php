<?php
include '../includes/header.php';
require_once '../core/dbconnection.php';
//require '../includes/functies.php';

if (isset($_POST['rVolgende'])) {

}

?>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="offset-2 col-md-8">
                <form class="needs-validation" novalidate action='verkoper.php' method="post">
                    <h1 class="h3 mb-3 text-center">Registreer je hier als verkoper!</h1>
                    <?php

                    ?>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label for="inputVoornaam">Bank</label>
                            <input type="text" name="rVoornaam" class="form-control" id="inputVoornaam"
                            pattern="[a-zA-Z]*" maxlength="50" placeholder="Voornaam" value="<?php if($_POST) { echo $_POST['rVoornaam'];} ?>" required>
                            <div class="invalid-feedback">
                              Voer een bank in.
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputTussennaam">Bankrekeningnummer</label>
                            <input type="text" name="rTussen" class="form-control" id="inputTussennaam" placeholder="Tussennaam"
                            pattern="[A-Za-z]*" maxlength="10" value="<?php if($_POST) { echo $_POST['rTussen'];} ?>">
                            <div class="invalid-feedback">
                              Voer een bankrekeningnummer in.
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputAchternaam">Creditcard</label>
                            <input type="text" name="creditcard" class="form-control" id="inputAchternaam" placeholder="Achternaam"
                            pattern="[A-Za-z]*" maxlength="41" value="<?php if($_POST) { echo $_POST['rAchternaam'];} ?>" required>
                            <div class="invalid-feedback">
                              Typ een creditcard in.
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="rVolgende" class="btn btn-primary" data-toggle="modal" data-target="#Modal">
                      Volgende
                    </button>
                </form>
            </div>
        </div>

    <?php
    /*else {
        include '../includes/404error.php';
    }*/

     include '../includes/footer.php'; ?>
