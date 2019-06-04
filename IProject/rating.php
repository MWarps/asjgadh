<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
geen problemen gevonden
*/
include 'includes/header.php';
require_once 'core/dbconnection.php';

if(isset($_GET['id'])){
  $verkoper = HaalBiederEnVerkoperOp($_GET['id'], $_GET['verkoper']);


?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header">
                    <h1>Beoordelinging van <?php $verkoper[1]['gebruikersnaam'];?></h1>
                    <div class="card-body">
                        <p>Beoordeel de algemene ervaring met <?php $verkoper[1]['gebruikersnaam']?> tijdens en na afloop van de veiling van <?php $verkoper[2]['titel']?></p>
                        <div class="icon-beoordeling">
                          <p><img src="assets/img/Boos.png"></img> <img src="assets/img/Blij.png" class="img-responsive pull-right"></img></p>
                        </div>
                        <form action="rating.php" method="post">
                          <div class="slidecontainer">
                            <input type="range" min="1" max="10" value="5" class="slider" id="myRange">
                            <p>Beoordeling: <span id="demo"></span></p>
                          </div>
                          <button type="submit" class="btn btn-primary btn-lg"></button>
                        </form>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
  </div>


    <?php
  }
  else {
    include 'includes/404error.php';
  }

    include 'includes/footer.php'; ?>
