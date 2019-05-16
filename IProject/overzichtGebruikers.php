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
                <a class="list-group-item list-group-item-action" href="overzichtVeilingen.php">Overzicht actieve veilingen</a>
            </ul>
        </div>
         </div><!--/row-->
    <div class="row">
        <form>
            <div class="form-group">
                <div class="offset-3 col-md-10 mt-1">
                    <div class="form-group col-md-4">
                        <!---<label for="inputState">Land</label>-->
                        <select id="inputState" class="form-control">
                            <option selected>Land</option>
                            <option>...</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div><!--/row-->
</div> <!--/.container-->
<?php
//}else{
//   include 'includes/404error.php';
//}
include 'includes/footer.php'
?>