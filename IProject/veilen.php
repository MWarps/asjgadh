<?php
include 'includes/header.php';

$pagina = 'veilen.php';
$melding = false;

if (!isset($_SESSION['catogorie'])){
    setupCatogorien();
}

if (isset($_SESSION['catalogus'])){
  if($_SESSION['catalogus']){
  setupCatogorien();}
  unset($_SESSION['catalogus']);
}

if(isset($_POST['volgende']) && !isset($_SESSION['rubriek'])){
    $melding = true;
}

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form class="needs-validation" novalidate action='veilen.php' method="post">
                <h1 class="h3 my-4 text-center "> Kies een rubriek! </h1>
                <p>Kies een rubriek om verder te gaan met het veilen van uw product.</p>
                <?php 
                if($melding){
                    echo  '<div class="form-row">
                                <div class="alert alert-warning" role="alert">
                                    <strong>Kies een rubriek!</strong>
                                </div>
                          </div>';
                        }
                ?>     
                <div class="form-row">
                             
                          <nav aria-label="breadcrumb">
                              <ol class="breadcrumb">
                                  <?php catogorieSoort($pagina); ?>
                              </ol>
                          </nav>                      
                  <div class="card bg-light card-breedte">
                      <div class="card-header bg-flame text-white text-uppercase"><i class="fa fa-list"></i> categorie&euml;n </div>
                      <?php directorieVinden($pagina); ?>
                  </div>
                    <button class="btn btn-lg bg-flame btn-block mb-5 mt-3" id="volgende" type="submit" name="volgende">Volgende</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>

