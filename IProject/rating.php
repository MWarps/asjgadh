<?php
include 'includes/header.php';
require_once 'core/dbconnection.php';



?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header">
                    <h1>Beoordelinging van <?php //$rating = HaalGebruikerOp($verkoper);?></h1>
                    <div class="card-body">
                        <p>Beoordeel het contact met <?php //$rating['gebruikersnaam']?> tijdens en na afloop van de veiling van <?php //$rating['titel']?></p>
                        <div class="slidecontainer">
                          <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
                          <p>Value: <span id="demo"></span></p>
                        </div>
                      
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
  </div>


    <?php
    
  

    include 'includes/footer.php'; ?>
