<?php
include 'includes/header.php';
setupCatogorien();


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
            
            <div class="col-md-4">
            <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="https://dummyimage.com/600x400/55595c/fff" alt="Card image cap">
            <h5 class="card-header"><a href="#">Product Naam</a></h5>
            <div class="card-body">
            <h4 class="card-text">€1,50</h4>
            <p class="card-text"><a href="#">Naam Verkoper</a><br>
            Land, stad</p>
            <a href="#" class="btn btn-block btn-primary">Ga naar artikel</a>
            </div>
            </div>
            </div>

<div class="col-md-4">
<div class="card" style="width: 18rem;">
<img class="card-img-top" src="https://dummyimage.com/600x400/55595c/fff" alt="Card image cap">
<h5 class="card-header"><a href="#">Product Naam</a></h5>
<div class="card-body">
<h4 class="card-text">BIEDEN</h4>
<p class="card-text"><a href="#">Naam Verkoper</a><br>
Land, stad</p>
<a href="#" class="btn btn-primary">Ga naar artikel</a>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card" style="width: 18rem;">
<img class="card-img-top" src="https://dummyimage.com/600x400/55595c/fff" alt="Card image cap">
<h5 class="card-header"><a href="#">Product Naam</a></h5>
<div class="card-body">
<h4 class="card-text">€125,00</h4>
<p class="card-text"><a href="#">Naam Verkoper</a><br>
Land, stad</p>
<a href="#" class="btn btn-primary">Ga naar artikel</a>
</div>
</div>
</div>
        </div> 
      </div>  
      </div>
    </div>
</div>


        <?php 
    include 'includes/footer.php' 
        ?>
