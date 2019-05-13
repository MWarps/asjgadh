<?php
include 'includes/header.php';
$mailVerstuurd = false;
$Ebestaat = false;

if (isset($_POST['Volgende'])){
  $email = $_POST['email'];

  if (empty(bestaatEmailadres($email))) {
    $Ebestaat = true;
  }

  else{
  $mailVerstuurd = true;
  $Code = rand(10000,99999);
  StuurWachtwoordResetMail($email, $Code);
  }
}
?>

<div class="container">
    <div class="row">
        <div class="offset-3 col-md-6 mt-4">
            <form class="needs-validation" novalidate action='register.php' method="post">
                <h1 class="h3 mb-4 text-center "> Voer uw emailadres in! </h1>
                <p> Er wordt een email verstuurd naar het ingevoerde emailadres. Klik de link in de mail op door te gaan met het resetten van uw wachtwoord.</p>
                <?php
                if($Ebestaat){
                    echo  '<div class="form-row">
                                      <div class="alert alert-warning" role="alert">
                                        <strong>Het ingevoerde emailadres bestaat niet!</strong> Voer het correcte adres in.
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
                    <button class="btn btn-lg bg-flame btn-block mb-5 mt-3" id="Volgende" type="submit" name="Volgende" value="Volgende"> Stuur mail </button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include 'includes/footer.php';
?>

