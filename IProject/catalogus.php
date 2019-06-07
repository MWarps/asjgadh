<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
geen problemen gevonden
*/
include 'includes/header.php';
$pagina = 'catalogus.php';
//$_SESSION['catalogus'] = true;

if (!isset($_SESSION['catogorie'])){
  $_SESSION['catogorie'] = array("Home"=>"-1");
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
                    <?php echo '<li class="breadcrumb-item"><a href="'.$pagina.'?id=-1" >Hoofdmenu</a></li>'; ?>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-light mb-3 h-100">
                <div class="card-header bg-flame text-white text-uppercase"><i class="fa fa-list"></i> categorie&euml;n </div>
                <?php directorieVinden($pagina); ?>
            </div>        
        </div>
        <div class="col-md-9">
            <div class="row">
                <?php haalAdvertentieOp($_SESSION['catogorie']['id']) ?>
            </div> 
        </div>  
    </div>
</div>

<?php 
include 'includes/footer.php' 
?>
