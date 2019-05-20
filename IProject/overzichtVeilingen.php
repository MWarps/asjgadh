<?php 
include 'includes/header.php';
//if (isset ($_SESSION['beheerder']) && $_SESSION['beheerder'] == true){     // veranderen naar admin variabel. 

?>

<div class="container">
    <div class="row">
        <div class="offset-3 col-md-6 mt-4">
            <h1 class="h3 mb-3 font-weight-normal text-center">Beheerders omgeving</h1>
            <h2 class="h3 mb-3 font-weight-normal text-center">Toegestane acties:</h2>
            <ul class="list-group">
                <a class="list-group-item list-group-item-action" href="beheerder.php">Terug naar overzicht</a>
                <a class="list-group-item list-group-item-action" href="overzichtGebruikers.php">Overzicht gebruikers</a>
            </ul>
        </div>
    </div>
    <form class="needs-validation" novalidate action='overzichtGebruikers.php' method="post">
        <div class="row">
            <div class="offset-1 col-md-10">
                <h1 class="h3 mb-3 font-weight-normal text-center">Veilingsnaam zoeken</h1>
                <div class="input-group mb-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="zoekopdracht" >Veilingsnaam:</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Gebruikersnaam" aria-label="titel" aria-describedby="basic-addon1"name="zoekopdracht"> 
                    <button class="btn btn-primary" type="submit" value="veilingzoeken" id="veilingzoeken" name="veilingzoeken">Zoeken</button>
                </div>
            </div>
        </div><!--/row-->
    </form>
    <div class="row">
        <div class="offset-0 col-md-12">
            <h1 class="h3 offset-2 mb-3 font-weight-normal text-center">Resultaten:</h1>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Voorwerpnr</th>
                        <th scope="col">Titel</th>
                        <th scope="col">Startprijs</th>
                        <th scope="col">verzendkosten</th>
                        <th scope="col">Betalingswijze</th>
                        <th scope="col">Plaatsnaam</th>
                        <th scope="col">Land</th>
                        <th scope="col">Looptijd</th>
                        <th scope="col">Looptijdbegindatum</th>
                        <th scope="col">looptrijdeinddatum</th>
                        <th scope="col">Verkoper</th>
                        <th scope="col">koper</th>
                        <th scope="col">veilinggeloten</th>
                        <th scope="col">verkoopprijs</th>
                        <th scope="col">geblokeerd</th>
                        <th scope="col">datum van blokeren</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['veilingzoeken'])){
                        gebruikersvinden($gebruikersnaam); 
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
//}else{
//   include 'includes/404error.php';
//}
include 'includes/footer.php'
?>