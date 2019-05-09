<?php
include '../includes/header.php';

if(isset($_SESSION['validatie'])){

echo strval($_SESSION['code']['verificatiecode']);

$input = $_SESSION['input'];

$error;
$overEindtijd = false;
$pogingen = false;
$Validatie = false;
$codeVerzonden = false;

if (isset($_POST['registreren'])){

    if(strval($_SESSION['code']['verificatiecode']) == $_POST['validatie'] && $_SESSION['pogingen'] < 3){
      if(date("H:i:s") > date("H:i:s", strtotime($_SESSION['code']['eindtijd']))){
        $overEindtijd = True;

      }
       else{
      $_SESSION['gebruikersnaam'] = $input['0'];
      unset($_SESSION['validatie']);
      $Validatie = true;

      updateGebruikerVerificatie($input);
      deleteVerificatieRij($input);

      header("Refresh:5 ; url=index.php");

    }

  }

    else{
      $pogingen = true;

      if($_SESSION['pogingen'] == 3){
        $error = 'U heeft heeft te veel foute codes ingevoerd. Klik op <strong> Verzend Code </strong> voor een nieuwe code.';
      }

      else{
      $_SESSION['pogingen']++;

      switch ($_SESSION['pogingen']) {
        case 1:
          $error = 'U heeft nog <strong>2</strong> pogingen.';
          break;
        case 2:
          $error = 'U heeft nog <strong>1</strong> poging.';
          break;
        case 3:
          $error = 'U heeft heeft te veel foute codes ingevoerd. Klik op <strong> Verzend Code </strong> voor een nieuwe code.';
          break;
        default;
          break;
          }
        }
      }
    }

  if (isset($_POST['verzendCode'])){
    $codeVerzonden = true;
    $_SESSION['pogingen'] = 0;
    deleteVerificatieRij($input);
    VerificatieCodeProcedure($input);
    $_SESSION['code'] = HaalVerficatiecodeOp($input);
    // StuurRegistreerEmail($input['1'], $input['11'], $_SESSION['code']['verificatiecode']);
  }
?>

<div class="container">
  <div class="row">
      <div class="offset-3 col-md-6 mt-4">
        <div class="jumbotron bg-dark text-white" style="padding: 2rem">
          <form class="needs-validation" novalidate action='validatie.php' method="post">
            <?php if($Validatie){
              echo '<div class="form-row">
                      <div class="alert alert-success" role="alert">
                        <strong>U bent geristreerd!</strong> U wordt doorgestuurd naar de hoofdpagina.
                        </div>
                      </div>
                    ';}
            ?>
              <h1 class="h3 mb-4 text-center "> Validatie </h1>
                  <p>  Er wordt een validatie code verstuurd naar het ingevoerde emailadres. <br> <br>
                  Voer hier de validatie code in om uw registratie te voltooien: </p>
                  <?php
                  if($codeVerzonden){
                    echo '<div class="form-row">
                            <div class="alert alert-success" role="alert">
                              <strong>Nieuwe code is verzonden!</strong> Er is een nieuwe code verzonden naar het emailadres.
                              </div>
                            </div>';}

                  if($overEindtijd){
                    echo '<div class="form-row">
                            <div class="alert alert-warning" role="alert">
                            <strong>De wachttijd is over datum!</strong>
                            Klik op <strong> Verzend Code </strong> om een nieuwe code te verzenden.
                            </div>
                          </div>';}

                  if($pogingen){
                    echo '<div class="form-row">
                            <div class="alert alert-warning" role="alert">
                            <strong>Foute ingevoerde code!</strong> '.$error.'
                            </div>
                          </div>' ;}
                  ?>

                  <div class="form-row">
                  <input type="text" name="validatie" class="form-control" id="inputValidatie" placeholder="Voer hier uw code in">
                  <div class="invalid-feedback">
                    Voer een code in.
                  </div>
                  <button class="btn btn-lg bg-flame btn-block mb-5 mt-3" id="registreren" type="submit" name="registreren" value="registreren"> Registreer </button>
                  <p> Klik op deze knop als u naar een paar minuten nog geen verificatie mail heeft gekregen: <p>
                  <!-- Button trigger modal -->
                  <button type="submit" class="btn btn-lg bg-flame btn-block" id="verzendCode" name="verzendCode" value="verzendCode" >
                    Verzend Code
                  </button>

                </div>
          </form>


          </div>
        </div>
      </div>
  </div>


<?php
      }
else{
  include '../includes/404error.php';
}
include '../includes/footer.php'?>
