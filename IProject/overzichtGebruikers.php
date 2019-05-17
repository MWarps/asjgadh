<?php 
include 'includes/header.php';
$gebruikersnaam = "";
//if (isset ($_SESSION['beheerder']) && $_SESSION['beheerder'] == true){     // veranderen naar admin variabel. 
                    if (isset($_POST['zoeken'])){
                        $gebruikersnaam = $_POST['zoekopdracht'];
                        echo 'ingevulde naam = ';
                        echo $gebruikersnaam;
                        
                    }
?>

<div class="container">
    <div class="row">
        <div class="offset-3 col-md-6 mt-4">
            <h1 class="h3 mb-3 font-weight-normal text-center">Beheerders omgeving</h1>
            <h2 class="h3 mb-3 font-weight-normal text-center">Toegestane acties:</h2>
            <ul class="list-group">
                <a class="list-group-item list-group-item-action" href="beheerder.php">Terug naar overzicht</a>
                <a class="list-group-item list-group-item-action" href="overzichtVeilingen.php">Overzicht actieve veilingen</a>
            </ul>
        </div>
    </div><!--/row-->
    <form class="needs-validation" novalidate action='overzichtGebruikers.php' method="post">
        <div class="row">
            <div class="offset-1 col-md-10">
                <h1 class="h3 mb-3 font-weight-normal text-center">Gebruikerszoeken</h1>
                <div class="input-group mb-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="zoekopdracht" >Gebruikersnaam:</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Gebruikersnaam" aria-label="gebruikersnaam" aria-describedby="basic-addon1"name="zoekopdracht"> 
                    <button class="btn btn-primary" type="submit" value="zoeken" id="zoeken" name="zoeken">Zoeken</button>
                </div>
            </div>
        </div><!--/row-->
    </form>
    <div class="row">
        <div class="offset-0 col-md-10">
            <h1 class="h3 offset-2 mb-3 font-weight-normal text-center">Resultaten:</h1>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Gebruikersnaam</th>
                        <th scope="col">Voornaam</th>
                        <th scope="col">Achternaam</th>
                        <th scope="col">Geslacht</th>
                        <th scope="col">Postcode</th>
                        <th scope="col">Plaatsnaam</th>
                        <th scope="col">Land</th>
                        <th scope="col">email</th>
                        <th scope="col">Verkoper</th>
                        <th scope="col">Geblokeerd</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
                    gebruikersvinden($gebruikersnaam); ?>
                </tbody>
            </table>
        </div>
    </div>
</div> <!--/.container-->
<?php
//}else{
//   include 'includes/404error.php';
//}
include 'includes/footer-fixed.php'
?>