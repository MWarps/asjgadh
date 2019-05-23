<?php
include 'includes/header.php';
require_once 'core/dbconnection.php';

if(isset($_SESSION['gebruikersnaam'])) {
  
$verkoper = gegevensIngevuld($_SESSION['gebruikersnaam']);
  
  if(!empty(gegevensIngevuld($_SESSION['gebruikersnaam']))) {
    if($verkoper[0]['gevalideerd'] == 1) {
      echo '<script language="javascript">window.location.href ="index.php"</script>';
    }
    else{
      echo '<script language="javascript">window.location.href ="verkoperValidatie.php"</script>';
    } 
    }
      
  
    
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
  $code = HaalVerficatiecodeOp($gebruiker['email'], $type);
  
  MaakVerkoperBrief($_SESSION['gebruikersnaam']);
  
  echo '<script language="javascript">window.location.href ="verkoperValidatie.php"</script>';
  exit();
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
                            pattern="[a-zA-Z]*" maxlength="50" placeholder="Bank" value="<?php if($_POST) { echo $_POST['bank'];} ?>" >

                            <label for="inputTussennaam">Bankrekeningnummer (Verplicht)</label>
                            <input type="text" name="bankrekeningnr" class="form-control" id="inputBankrekeningnr" placeholder="Bankrekeningnr"
                            pattern="[A-Za-z0-9]*" maxlength="10" value="<?php if($_POST) { echo $_POST['bankrekeningnr'];} ?>">

                            <label for="inputAchternaam">Creditcard (optioneel)</label>
                            <input type="text" name="creditcard" class="form-control" id="inputcreditcard" placeholder="Creditcard"
                            pattern="[A-Za-z]*" maxlength="41" value="<?php if($_POST) { echo $_POST['creditcard'];} ?>" >
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
