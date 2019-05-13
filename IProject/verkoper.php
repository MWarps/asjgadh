<?php
include 'includes/header.php';
require_once 'core/dbconnection.php';
if(isset($_SESSION['gebruikersnaam'])){

    if (gegevensIngevuld() == true){
       header('location: verkoperValidatie.php');
    }
$stuurMail = false;

if (isset($_POST['rVolgende'])) {
  $bank = $_POST['bank'];
  $bankrekeningnr = $_POST['bankrekeningnr'];
  $creditcard = $_POST['creditcard'];

  $input = array($bank, $bankrekeningnr, $creditcard);

  //$_SESSION['status'] = 'verkoper';
  header('location: status.php');
}

?>
    <div class="container">
        <div class="row ">
          <div class="offset-3 col-md-6 mt-4">
            <div class="jumbotron bg-dark text-white" style="padding: 2rem">
                <form class="needs-validation" novalidate action='verkoper.php' method="post">
                    <h1 class="h3 mb-3 text-center">Registreer je hier als verkoper!</h1>
                                            <div class="form-row">
                            <label for="inputVoornaam">Bank (Verplicht)</label>
                            <input type="text" name="bank" class="form-control" id="inputBank"
                            pattern="[a-zA-Z]*" maxlength="50" placeholder="Bank" value="<?php if($_POST) { echo $_POST['bank'];} ?>" >

                            <label for="inputTussennaam">Bankrekeningnummer (Verplicht)</label>
                            <input type="text" name="bankrekeningnr" class="form-control" id="inputBankrekeningnr" placeholder="Bankrekeningnr"
                            pattern="[A-Za-z]*" maxlength="10" value="<?php if($_POST) { echo $_POST['bankrekeningnr'];} ?>">

                            <label for="inputAchternaam">Creditcard (optioneel)</label>
                            <input type="text" name="creditcard" class="form-control" id="inputcreditcard" placeholder="Creditcard"
                            pattern="[A-Za-z]*" maxlength="41" value="<?php if($_POST) { echo $_POST['creditcard'];} ?>" >
                    </div>
                    <button type="submit" name="rVolgende" class="btn btn-lg bg-flame btn-block mt-3">
                      Volgende
                    </button>
                </form>
              </div>
            </div>
        </div>


    <?php
  }
    else {
       include 'includes/404error.php';
   }

     include 'includes/footer.php'; ?>
