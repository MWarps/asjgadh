<?php
include 'includes/header.php';

//if (isset ($_SESSION['gebruikersnaam'])){


$pogingen = false;
$overEindtijd = false;


if (isset($_POST['valideren'])){
     
    try {
            require('core/dbconnection.php');
                $sqlSelect = $dbh->prepare("SELECT gebruikersnaam,type, verificatiecode, eindtijd FROM Verificatie
                WHERE type = 'post' AND gebruikersnaam = :gebruikersnaam ");
            $sqlSelect->execute(
                array (
                    ':gebruikersnaam' => $_SESSION['gebruikersnaam'],
                ));

            $verkoperVerificatie = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOexception $e) {
            echo "er ging iets mis error: {$e->getMessage()}";
        }
    
    
    if(strval($verkoperVerificatie['verificatiecode']) == $_POST['validatie'] && $_SESSION['pogingen'] < 3){

        if(date("d:H:i:s") > date("d:H:i:s", strtotime($verkoperVerificatie['eindtijd'])) ){
            $overEindtijd = True;
        }

        else{
            $_SESSION[' valideren'] = true;
            header("Location: index.php");
        }
    }

    else{
        $pogingen = true;

        if($_SESSION['pogingen'] == 3){
            $error = 'U heeft heeft te veel foute codes ingevoerd. Klik op <strong> Verzend Code </strong> voor een nieuwe code.';
        }

        else{
            $_SESSION['pogingen']++;

            switch ($_SESSION['pogingen']) {
                case 1:
                    $error = 'U heeft nog <strong>2</strong> pogingen.';
                    break;
                case 2:
                    $error = 'U heeft nog <strong>1</strong> poging.';
                    break;
                case 3:
                    $error = 'U heeft heeft te veel foute codes ingevoerd. Klik op <strong> Verzend Code </strong> voor een nieuwe code.';
                    break;
                default;
                    break;
            }
        }
    }
}
?>

<div class="container">
    <div class="row">
        <div class="offset-3 col-md-6 mt-4 border border-dark rounded">
            <form class="needs-validation " novalidate action='validatie.php' method="post">
                <h1 class="h3 mb-4 mt-2 text-center "> Validatie </h1>
                <p> <br> Voer hier de validatiecode in om uw registratie te voltooien: </p>
                <?php
                if($overEindtijd){
                    echo '<div class="form-row">
                            <div class="alert alert-warning" role="alert">
                            <strong>De wachttijd is over datum!</strong>
                            Klik op <strong> Verzend Code </strong> om een nieuwe code te verzenden.
                            </div>
                          </div>';}

                if($pogingen){
                    echo '<div class="form-row">
                            <div class="alert alert-warning" role="alert">
                            <strong>Foute ingevoerde code!</strong> '.$error.'
                            </div>
                          </div>' ;}
                ?>

                <div class="form-row">
                    <input type="text" name="validatie" class="form-control" id="inputValidatie" placeholder="Voer hier uw code in">
                    <div class="invalid-feedback">
                        Voer een code in.
                    </div>
                    <button class="btn btn-lg bg-flame btn-block mb-5 mt-3" id="valideren" type="submit" name="valideren" value="valideren"> valideren </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
//} else {
    
//}
include 'includes/footer.php';
?>