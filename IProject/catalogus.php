<?php
include 'includes/header.php';
setupCatogorien();

if (isset($_GET['id'])){
    catogorieToevoeging ();
    //print_r( $_SESSION['catogorie']); // terug gaan werk via pijlen niet via bradcrumb
    
}
$beschrijving = haalAdvertentieOp();
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
          
          <div class="col-md-9">
                <div class="col">
                    <div class="card mb-3">
                        <div class="row">
                            <div class="col-md-2">
                                <img class="rounded thumbnail" src="https://dummyimage.com/170x170/55595c/fff">
                            </div>                  
                            <div class="col-md-8 pr-0 border-right">               
                                <h4 class="card-header"><a href='#'>Lorem ipsum dolor sit amet</a></h4> 
                                <div class="card-body">
                                <iframe width="100%" height="70px" srcdoc='<html><body><?php echo $beschrijving['beschrijving']; ?></body></html>'></iframe>
                              </div>                          
                            </div>
                            <div class="col-md-2 pl-0">                 
                                <h4 class="card-header"> Bieden </h4>
                                <div class="card-body">
                                    <a href="#">Lucas</a>
                                    <br>
                                    Nederland,
                                    <br>
                                    Gendt                       
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
                <div class="col">
                    <div class="card mb-3">
                        <div class="row">
                            <div class="col-md-2">
                                <img class="rounded thumbnail" src="https://dummyimage.com/170x170/55595c/fff">
                            </div>                  
                            <div class="col-md-8 pr-0 border-right">               
                                <h4 class="card-header"><a href='#'>Lorem ipsum dolor sit amet</a></h4> 
                                <div class="card-body">
                                <iframe width="100%" height="70px" srcdoc='<html><body><?php echo $beschrijving['beschrijving']; ?></body></html>'></iframe>
                              </div>                          
                            </div>
                            <div class="col-md-2 pl-0">                 
                                <h4 class="card-header"> Bieden </h4>
                                <div class="card-body">
                                    <a href="#">Lucas</a>
                                    <br>
                                    Nederland,
                                    <br>
                                    Gendt                       
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
