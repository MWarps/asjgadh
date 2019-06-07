<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
geen problemen gevonden
*/
include 'includes/header.php';

if(!isset($_SESSION['gebruikersnaam'])){    
    $type = 'email'; 
    $Ebestaat = false;
    $mailVerstuurd = false;

    if (isset($_POST['registreren'])){
        $email = $_POST['email'];
      
        // controleert of emailadres bestaat
        if(empty(bestaatEmailadres($email)) || empty(bestaatValidatie($email, $type))) {
            $Ebestaat = true;
          
        }
        else{
          $mailVerstuurd = true;
                 
          VerificatieCodeProcedure($email, $type);
          $code = HaalVerficatiecodeOp($email, $type);
                      
          StuurRegistreerEmail($email, $code['verificatiecode']);
        }
      
    }
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-4">
            <form class="needs-validation" novalidate action='register.php' method="post">
                <h1 class="h3 mb-4 text-center "> Voer uw emailadres in! </h1>
                <p> Er wordt een email verstuurd naar het ingevoerde emailadres. Klik de link in de mail op door te gaan met registreren.</p>
                <?php
    if($Ebestaat){
        echo  '<div class="form-row">
                          <div class="alert alert-warning" role="alert">
                            <strong>Het ingevoerde email adres is al in gebruik!</strong>
                          </div>
                         </div>';}
    if($mailVerstuurd){
         echo '<div class="form-row">
              <div class="alert alert-success" role="alert">
              <strong>Email is verzonden!</strong> Er is een mail verzonden naar het emailadres met een link om door te gaan met registreren.
                </div>
               </div>';}
                ?>
                <div class="form-row">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Voer hier uw email in"
                           maxlength="254" required>
                    <div class="invalid-feedback">
                        Voer een emailadres in.
                    </div>
                    <button class="btn btn-lg bg-flame btn-block mb-5 mt-3" id="registreren" type="submit" name="registreren" value="registreren"> Stuur mail </button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
}
else{
  unset($_SESSION['gebruikersnaam']);
    include 'includes/404error.php';
}
include 'includes/footer.php';
?>
