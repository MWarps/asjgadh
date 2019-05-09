<?php
session_start();
require 'functies.php';
$ingelogd;

if (isset($_SESSION['gebruikersnaam'])){
  $ingelogd = true;
}

else {
  $ingelogd = false;
}

 ?>
<!doctype html>
<html lang="nl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>EenmaalAndermaal</title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="/assets/css/bootstrap/bootstrap.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Custom css -->
        <link rel="stylesheet" type="text/css"  href="../assets/css/style.css"/>
        <link rel="stylesheet" type="text/css"  href="assets/css/style.css"/>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-flame">
                <div class="container">
                    <a class="navbar-brand" href="#">Navbar</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-collapse collapse">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-items">
                                <a class="nav-link" href="../index.php">Home<span class="sr-only">(current)</span></a>
                            </li>
                        </ul>
                        <?php knoppenFunctie($ingelogd);
                        ?>
                    </div>
                </div>
            </nav>
            <nav class="navbar navbar-expand-lg navbar-light bg-orange2 spacing justify-content-md-center">
                <form class="form-inline my-2 my-md-0">
                    <ul class="navbar-nav">
                        <li class="navbar-item p-2">
                            <input class="form-control" type="text" placeholder="Zoeken" aria-label="Search">
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="navbar-item p-2">
                            <input class="form-control" type="text" placeholder="Selecteer Rubriek" aria-label="Search">
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="navbar-item p-2">
                            <input class="form-control" type="text" placeholder="Postcode" aria-label="Search">
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="navbar-item p-2">
                            <input class="form-control" type="text" placeholder="Selecteer afstand" aria-label="Search">
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="navbar-item p-2">
                            <button type="submit" class="btn btn-light">Verstuur</button>
                        </li>
                    </ul>
                </form>
            </nav>
        </header>
