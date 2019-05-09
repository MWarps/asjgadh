<?php
require_once '../core/dbconnection.php';
include '../includes/header.php';
include '../includes/functies.php';
?>
<div class="container">
    <div class="offset-2 col-md-8 mt-4">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading"></h4>
            <p>U wordt uitgelogd.</p>
            <p class="mb-2">U wordt terug gestuurd naar de homepage, Ogenblik geduld alstublieft.</p>
        </div>
    </div>
</div>
<?php uitloggen(); ?>

<?php 
include '../includes/footer.php'    
?>