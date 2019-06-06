<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
geen problemen gevonden
*/
include 'includes/header.php';

if (isset($_GET['id']) || isset($_POST['veranderWachtwoord'])) {

 if (isset($_GET['id'])) {
  $_SESSION['validatie'] = haalCodeOp($_GET['id']);
 }    

    if (isset($_POST['veranderWachtwoord'])){
      $Validatie = true;
      $_SESSION['status'] = 'wachtwoordreset';
      
      $hashedWachtwoord = password_hash($_POST['nWachtwoord1'], PASSWORD_DEFAULT);
      veranderWachtwoord($_SESSION['validatie']['email'], $hashedWachtwoord);
      deleteVerificatieRij($_SESSION['validatie']['email'], $_SESSION['validatie']['type']);
      
      unset($_SESSION['validatie']);
      $url = 'index.php';
      //echo '<script language="javascript">window.location.href ="'.$url.'"</script>';
      //exit();
}


?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-4">
                <div class="jumbotron bg-dark text-white">
                    <form class="needs-validation" novalidate action='wachtwoordReset2.php' method="post"
                          oninput='nWachtwoord1.setCustomValidity(nWachtwoord1.value != nWachtwoord2.value ? "Passwords do not match." : "")'>
                               <?php if($Validatie){
                               echo ' <div class="alert alert-success" role="alert">
                                        <strong>U wachtwoord is gewijzigd</strong> U wordt doorgestuurd naar de hoofdpagina.
                                      </div>
                                ';}
                                ?>
                          <h1 class="h3 mb-3 mt-3 font-weight-normal>">Wachtwoord resetten</h1>
                            <!-- hieronder wordt het nieuwe wachtwoord gegeven (X2) -->
                            <label for="inputWachtwoord1">Nieuw wachtwoord</label>
                            <input type="password" name="nWachtwoord1" class="form-control" id="inputWachtwoord1"
                                   pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Wachtwoord" required>
                            <div class="invalid-feedback">
                                Voer een wachtwoord in met minimaal 8 tekens, 1 kleine letter, 1 hoofdletter en 1 teken.
                            </div>

                            <label for="inputWachtwoord2">Herhaal nieuw wachtwoord</label>
                            <input type="password" name="nWachtwoord2" class="form-control" id="inputWachtwoord"
                                   pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Wachtwoord" required>
                            <div class="invalid-feedback">
                                Voer hetzelfde wachtwoord in.
                            </div>
                            <!-- hier wordt de reset button gemaakt. -->
                            <button  type="submit" value="veranderWachtwoord" id="veranderWachtwoord" name="veranderWachtwoord" class="btn bg-flame mt-3">Reset Wachtwoord</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
}

else {
  include 'includes/404error.php';
}
include 'includes/footer-fixed.php'; ?>
