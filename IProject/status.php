<?php
header("Refresh:5; url=index.php");
include 'includes/header.php';

if (isset($_GET['uitlog'])){
$_SESSION['status'] = $_GET['uitlog'];
}

switch ($_SESSION['status']) {
  case 'login':
        $status = 'U bent ingelogd!';
    break;
  case 'registreren':
        $status = 'U bent geregistreerd!';
    break;
  case 'uitlog':
        $status = 'U bent uitgelogd!';
        session_unset();
        session_destroy();
    break;
  case 'wachtwoordreset':
        $status = 'U wachtwoord is veranderd!';
    break;
    case 'verkoper'
    $status = 'U bent geristreerd!';
  default:
    // code...
    break;
}



?>
<div class="container">
    <div class="offset-2 col-md-8 mt-4">
        <div class="alert bg-orange2" role="alert">
            <h4 class="alert-heading"></h4>
            <?php

            unset($_SESSION['status']);
            echo $status.'
            <p class="mb-2">U wordt doorgestuurd naar de homepage, Ogenblik geduld alstublieft.</p>';


            ?>
        </div>
    </div>
</div>
<?php

include 'includes/footer-fixed.php'
?>
