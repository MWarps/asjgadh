<?php
session_start();
require 'includes/functies.php';
require_once 'core/dbconnection.php';
$VerkoperValidatie = false;

if(!isset($_SESSION['rubriek'])){
    $_SESSION['rubriek']['subrubriek1'] = -1;
}
if(isset($_GET['id'])){ 
    $_SESSION['rubriek2'] = $_GET['id'];
}

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
    if (checkGEBLOKEERD ($_SESSION['gebruikersnaam']) == true){
        session_unset;
        session_destroy;
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

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Zorgt voor dat css die voor mobiel worden gebruikt ook alleen worden gezien bij mobiel window. -->
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
    if (isset($_SESSION['gebruikersnaam'])){
        if ($VerkoperValidatie == false){                                              
            echo '<a class="btn btn-primary" href="veilen.php">Veilen</a>';                                            
        } ?>  
                    <ul class="navbar-nav">                            
                        <div class="nav-item dropdown">

                            <button class="btn btn-flame dropdown-toggle" type="button" id="accountbeheer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <?php echo $_SESSION['gebruikersnaam']; ?>
                            </button>     

                            <div class="dropdown-menu" aria-labelledby="accountbeheer">
                                <a class="dropdown-item" href="beheerder.php">Beheer</a>
                                <a class="dropdown-item" href="#">Meldingen</a>
                                <a class="dropdown-item" href="../informeren.php">FAQ</a>
                                <a class="dropdown-item" href="wachtwoordReset.php">Wachtwoord Resetten</a>                                
                                <?php if ($VerkoperValidatie){                                              
            echo '<a class="dropdown-item" href="verkoper.php">Verkoper worden</a>
                  <a class="dropdown-item" href="mijnadvertenties.php">Mijn advertenties</a>';                                            
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
                                        <a class="nav-link" href="register.php">Registreren</a>
                                      </li>
                                   </ul>';
    } ?>
            </div>
            </div>          
        </nav>

