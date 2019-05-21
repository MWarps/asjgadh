<?php
session_start();
require 'includes/functies.php';
require_once 'core/dbconnection.php';
$VerkoperValidatie = false;

if(isset($_SESSION['gebruikersnaam'])){
  
  if(empty(gegevensIngevuld($_SESSION['gebruikersnaam']))){
    $VerkoperValidatie = true;    
  }
  if(!empty(gegevensIngevuld($_SESSION['gebruikersnaam']))){
    $verkoper = gegevensIngevuld($_SESSION['gebruikersnaam']);
    if($verkoper[0]['gevalideerd'] == 0){
      $VerkoperValidatie = true;    
    }
  }
}

?>
<!DOCTYPE HTML>
<html lang="nl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="Homepage" content="Online koop en verkoop van 2e handsgoederen">
        <title>EenmaalAndermaal</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="/assets/css/bootstrap/bootstrap.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Custom css -->
        <link rel="stylesheet" type="text/css"  href="../assets/css/style.css"/>
        <link rel="stylesheet" type="text/css"  href="assets/css/style.css"/>
        
        
    </head>
    <body>          
          <nav class="navbar navbar-expand-lg navbar-light bg-flame">
                <div class="container">
                    <a class="navbar-brand" href="#"><img src="assets/img/EenmaalAndermaal.png" width="40" height="40" title="EenmaalAndermaal" alt="EenmaalAndermaal"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-collapse collapse " id="navbarNavDropdown">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-items">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                        </ul>
                        
                        <?php
                        if (isset($_SESSION['gebruikersnaam'])){ ?>
                              <ul class="navbar-nav">                            
                                      <div class="nav-item dropdown">
                                        <button class="btn dropdown-toggle" type="button" id="accountbeheer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <?php echo $_SESSION['gebruikersnaam']; ?>
                                        </button>                                                           
                                      <div class="dropdown-menu" aria-labelledby="accountbeheer">
                                          <a class="dropdown-item" href="#">Beheer</a>
                                          <a class="dropdown-item" href="#">Meldingen</a>
                                          <a class="dropdown-item" href="../informeren.php">FAQ</a>
                                      <?php if ($VerkoperValidatie){                                              
                                    echo '<a class="dropdown-item" href="../verkoper.php">Verkoper worden</a>';                                            
                                      } ?>    
                                    </div>
                                  </div>
                                      <li class="nav-item">
                                          <a class="nav-link" href="index.php?uitlog=uitlog">Uitloggen</a>
                                      </li>
                                    </ul>
                                    </div>
                                    
                        <?php  } // einde if session actief is
                          else{
                              echo'<ul class="navbar-nav">
                                                  <li class="nav-item">
                                                      <a class="nav-link" href="login.php">Login</a>
                                                  </li>
                                                  <li class="nav-item">
                                                      <a class="nav-link" href="register.php">Register</a>
                                                  </li>
                                              </ul>';
                          } ?>
                          </div>
                      </div>
                
            </nav>
            <nav class="navbar navbar-expand-lg navbar-light bg-orange2 spacing justify-content-md-center">
                <form class="form-inline my-2 my-md-0 needs-validation" novalidate action="catalogus.php" method="POST">
                    <ul class="navbar-nav">
                        <li class="navbar-item p-2">
                            <input class="form-control" name="zoektekst" type="text" placeholder="Product Naam" aria-label="Search">
                        </li>
                    </ul>
                      <select name="Rubriek" class="form-control" id="inputRubriek">
                        <?php HaalRubriekop(); ?>
                        </select>
                    <ul class="navbar-nav">
                        <li class="navbar-item p-2">
                            <button type="submit" class="btn btn-light">Verstuur</button>
                        </li>
                    </ul>
                </form>
            </nav>
      