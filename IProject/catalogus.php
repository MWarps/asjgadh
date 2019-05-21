<?php
include 'includes/header.php';
setupCatogorien();
$zoektekst = '';
$rubriek;
if(isset($_GET['zoek'])){
  $rubriek = $_GET['rubriek'];
  if(isset($_GET['zoektekst'])){
    $zoektekst = $_GET['zoektekst'];
  }
}
$rubriek = 157347;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <?php catogorieSoort(); ?>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-light mb-3">
                <div class="card-header bg-flame text-white text-uppercase"><i class="fa fa-list"></i> categorie&euml;n </div>
                <?php directorieVinden() ?>
            </div>        
          </div>
          <div class="col-md-9">
          <div class="row">
          <?php haalAdvertentieOp($rubriek, $zoektekst) ?>
        </div> 
      </div>  
      </div>
    </div>
</div>
        <?php 
    include 'includes/footer.php' 
        ?>
