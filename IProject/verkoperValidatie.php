<?php
include 'includes/header.php';

$verkoper = gegevensIngevuld($_SESSION['gebruikersnaam']);

if(!empty(gegevensIngevuld($_SESSION['gebruikersnaam']))) {
  if($verkoper[0]['gevalideerd'] == 1) {
    echo '<script language="javascript">window.location.href ="index.php"</script>';
  }  
  }
  
  if(empty(gegevensIngevuld($_SESSION['gebruikersnaam']))) {
    echo '<script language="javascript">window.location.href ="verkoper.php"</script>';
  }
  
$error = false;
$overEindtijd = false;

if (isset($_POST['valideren'])){
    $type = 'brief';
    $gebruiker = HaalGebruikerOp($_SESSION['gebruikersnaam']);
    $code = HaalVerficatiecodeOp($gebruiker['email'], $type); 
    $type = 'brief';
    
    if(strval($code['verificatiecode']) == $_POST['validatie']){
            unset($_SESSION['beschrijving']);
            $_SESSION['status'] = 'verkoper';
            deleteVerificatieRij($gebruiker['email'], $type);
            statusOpValidatieZetten($_SESSION['gebruikersnaam']);
            
            echo '<script language="javascript">window.location.href ="index.php"</script>';
            exit();
    }
    else{
        $error = true;
    }
}
?>

<div class="container">
    <div class="row">
        <div class="offset-3 col-md-6 mt-4">
            <form class="needs-validation " novalidate action='verkoperValidatie.php' method="post">
                <h1 class="h3 mb-4 mt-2 text-center "> Validatie </h1>
                <p> <br> Voer hier de validatiecode in om uw registratie te voltooien: </p>
                <?php
                

                if($error){
                    echo '<div class="form-row">
                            <div class="alert alert-warning" role="alert">
                            <strong>Foute ingevoerde code!</strong> voer de correcte code in.
                            </div>
                          </div>' ;}
                ?>

                <div class="form-row">
                    <input type="text" name="validatie" class="form-control" id="inputValidatie" placeholder="Voer hier uw code in">
                    <div class="invalid-feedback">
                        Voer een code in.
                    </div>
                    <button class="btn btn-lg bg-flame btn-block mb-5 mt-3" id="valideren" type="submit" name="valideren" value="valideren"> valideren </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php


include 'includes/footer.php';
?>