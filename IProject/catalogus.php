<?php
include 'includes/header.php';
setupCatogorien();

if (isset($_GET['id'])){
    catogorieToevoeging ();
    //print_r( $_SESSION['catogorie']); // terug gaan werk via pijlen niet via bradcrumb
    
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
        <div class="col-12 col-sm-3">
            <div class="card bg-light mb-3">
                <div class="card-header bg-flame text-white text-uppercase"><i class="fa fa-list"></i> categorie&euml;n </div>
                <?php    directorieVinden() ?>
            </div>
            <div class="card bg-light mb-3">
                <div class="card-header bg-success text-white text-uppercase">Last product</div>
                <div class="card-body">
                    <img class="img-fluid" src="https://dummyimage.com/600x400/55595c/fff" />
                    <h5 class="card-title">Product title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <p class="bloc_left_price">99.00 $</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="row">

                <div class="col-12">
                    <div class="card h-70 mb-3">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="https://dummyimage.com/170x170/55595c/fff">
                            </div>                  
                            <div class="col-md-8 border-right pr-0">               
                                <h4 class="card-header"><a href='#'>Lorem ipsum dolor sit amet</a></h4> 
                                <p class="card-text pl-2">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi </p>                          
                            </div>
                            <div class="col-md-2 pl-0">                 
                                <h4 class="card-header"> Bieden </h4>
                                <div class="card-text p-2">
                                    <a href="#"> Naam verkoper </a>
                                    <p> Land, stad </p>                          
                                </div>
                            </div>
                        </div>
                    </div>
                </div>              
            </div>
        </div>


        <?php 
    include 'includes/footer-fixed.php' 
        ?>
