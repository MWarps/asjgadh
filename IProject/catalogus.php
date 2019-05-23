<?php
include 'includes/header.php';
if (!isset($_SESSION['catogorie'])){
    setupCatogorien();
}

if(isset($_GET['id'])){
    $_SESSION['catogorie']['id'] = $_GET['id'];
}

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
                <?php //haalAdvertentieOp($rubriek, $zoektekst);  
                ?>

            </div> 
        </div>  
    </div>
</div>

<?php 
include 'includes/footer.php' 
?>
