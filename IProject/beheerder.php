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
                <a class="list-group-item list-group-item-action" href="overzichtGebruikers.php">Overzicht gebruikers</a>
                <a class="list-group-item list-group-item-action" href="overzichtVeilingen.php">Overzicht actieve veilingen</a>
            </ul>
        </div>
    </div>
</div>
<?php
//}else{
//   include 'includes/404error.php';
//}
include 'includes/footer.php'
?>