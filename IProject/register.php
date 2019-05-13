<?php
include 'includes/header.php';

if(!isset($_SESSION['gebruikersnaam'])){
    $Ebestaat = false;

    if (isset($_POST['registreren'])){
        $email = $_POST['email'];

        // controleert of emailadres bestaat
        if(!empty(bestaatEmailadres($email)) || !empty(bestaatValidatie($email))) {
            $Ebestaat = True;
        }

        else{
            $_SESSION['email'] = $email;
            $_SESSION['type'] = 'mail';
            VerificatieCodeProcedure($email, $_SESSION['type']);
            $code = HaalVerficatiecodeOp($email, $_SESSION['type']);
            $_SESSION['code'] = $code;
            $_SESSION['pogingen'] = 0;

            StuurRegistreerEmail($email, $code['verificatiecode']);

            header("Location: validatie.php");
        }
    }
?>

<div class="container">
    <div class="row">
        <div class="offset-3 col-md-6 mt-4">
            <form class="needs-validation" novalidate action='register.php' method="post">
                <h1 class="h3 mb-4 text-center "> Voer uw emailadres in! </h1>
                <?php
    if($Ebestaat){
        echo  '<div class="form-row">
                          <div class="alert alert-warning" role="alert">
                            <strong>Het ingevoerde email adres is al in gebruik!</strong>
                          </div>
                         </div>';
    }
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
include 'includes/footer-fixed.php';
?>
