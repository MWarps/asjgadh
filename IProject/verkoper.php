<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
geen problemen gevonden
*/
include 'includes/header.php';
require_once 'core/dbconnection.php';

if(isset($_SESSION['gebruikersnaam'])) {
  
$verkoper = gegevensIngevuldVerkoper($_SESSION['gebruikersnaam']);
            
  if (isset($_POST['rVolgende'])) {
  $bank = $_POST['bank'];
  $bankrekeningnr = $_POST['bankrekeningnr'];
  $creditcard = $_POST['creditcard'];
  $type = 'brief';
  
  $input = array($_SESSION['gebruikersnaam'], $bank, $bankrekeningnr, $creditcard);
  $mailVerstuurd = true;
  
  $gebruiker = HaalGebruikerOp($_SESSION['gebruikersnaam']);
  insertVerkoper($input);
  VerificatieCodeProcedure($gebruiker['email'], $type);
    
}

if(!empty(gegevensIngevuldVerkoper($_SESSION['gebruikersnaam']))) {
  if($verkoper['gevalideerd'] == 1) {
    echo '<script language="javascript">window.location.href ="index.php"</script>';
  }
  else{
    echo '<script language="javascript">window.location.href ="verkoperValidatie.php"</script>';
  } 
  }
?>
    <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 mt-4">
            <div class="jumbotron bg-dark text-white" style="padding: 2rem">
                <form class="needs-validation" novalidate action='verkoper.php' method="post">
                    <h1 class="h3 mb-3 text-center">Registreer je hier als verkoper!</h1>
                                            <div class="form-row">
                            <label for="inputVoornaam">Bank (Verplicht)</label>
                            <input type="text" name="bank" class="form-control" id="inputBank"
                            pattern="[a-zA-Z]{1,4}" maxlength="4" minlength="4" placeholder="Bank" value="<?php if($_POST) { echo $_POST['bank'];} ?>" required>

                            <label for="inputTussennaam">Bankrekeningnummer (Verplicht)</label>
                            <input type="text" name="bankrekeningnr" class="form-control" id="inputBankrekeningnr" placeholder="Bankrekeningnr"
                            pattern="[A-Za-z0-9]*" maxlength="18" value="<?php if($_POST) { echo $_POST['bankrekeningnr'];} ?>" required>

                            <label for="inputAchternaam">Creditcard (optioneel)</label>
                            <input type="text" name="creditcard" class="form-control" id="inputcreditcard" placeholder="Creditcard"
                            pattern="[A-Za-z]*" maxlength="41" value="<?php if($_POST) { echo $_POST['creditcard'];} ?>">
                    </div>
                    <button type="submit" name="rVolgende" id="rVolgende" class="btn btn-lg bg-flame btn-block mt-3">
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
