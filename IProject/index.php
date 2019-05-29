<?php
include 'includes/header.php';
$pagina = 'catalogus.php';
setupCatogorien();
// Kijkt er geklikt is op de knop uitloggen
if (isset($_GET['uitlog'])){
    $_SESSION['status'] = $_GET['uitlog'];
    session_unset();
    session_destroy();
    $url = 'index.php';
    echo '<script language="javascript">window.location.href ="'.$url.'"</script>';
    die();
}

// Geeft een melding a.d.h.v de status
if(isset($_SESSION['status'])){

    switch ($_SESSION['status']) {
        case 'login':
            $status = 'U bent ingelogd!';
            break;
        case 'registreren':
            $status = 'U bent geregistreerd!';
            break;
        case 'wachtwoordreset':
            $status = 'U wachtwoord is veranderd!';
            break;
        case 'verkoper':
            $status = 'U bent geregistreerd als verkoper!';
            break;
        case 'voorwerp':
            $status = 'Voorwerp is succesvol te koop gezet!';
            break;
        default:
            // code...
            break;
    }

    unset($_SESSION['status']);

    // laat melding zien aan gebruiker
    echo '<div class="container">
            <div class="h-100 row align-items-center">
              <div class="col">
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                          <strong>'.$status.'</strong> U kunt op het kruisje klikken om deze melding te sluiten.
                          <button type="button" class="close pt-0" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                </div>
              </div>
            </div>';
}
?>


<div class="container-fluid">
    <div class="row mt-2">
     <div class="col-md-3">
            <div class="card bg-light mb-3">
                <div class="card-header bg-orange2 text-white text-uppercase"><i class="fa fa-list"></i> 
                  categorie&euml;n 
                </div>
                <button class="dropdown-menu card-header bg-orange2 text-white text-uppercase">categorie</button>
                <?php    directorieVinden($pagina) ?>
            </div>
        </div>
    <!--/span-->

    <div class="col-md-9">
    <div class="row">
        <?php if (isset($_SESSION['gebruikersnaam'])) {
        echo '<button type="button" class="btn btn-secondary btn-sm btn-block">Laatst Bekeken</button>';
         getLaatstBekeken($_SESSION['gebruikersnaam']);
        echo '<button type="button" class="btn btn-secondary btn-sm btn-block">Aanbevolen</button>';
         getAanbevolen($_SESSION['gebruikersnaam']);         
          } 
        echo '<button type="button" class="btn btn-secondary btn-sm btn-block">Populairste Artikelen</button>';  
          
        getPopulairsteArtikelen();
         ?>
      </div>
    </div>
</div><!--/row-->
</div><!--/.container-->

<?php include 'includes/footer.php'; ?>
