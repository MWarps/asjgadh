<?php
include 'includes/header.php';

if(isset($_SESSION['email']) && !isset($_SESSION['gebruikersnaam'])){

    $email = $_SESSION['email'];
    $type = $_SESSION['type'];
    $code = $_SESSION['code']['verificatiecode'];
    $eindtijd = $_SESSION['code']['eindtijd'];

    $error;
    $overEindtijd = false;
    $pogingen = false;
    $Validatie = false;
    $codeVerzonden = false;

    if (isset($_POST['registreren'])){

        if(strval($code) == $_POST['validatie'] && $_SESSION['pogingen'] < 3){

            if(date("d:H:i:s") > date("d:H:i:s", strtotime($eindtijd)) ){
                $overEindtijd = True;
            }

            else{
                $_SESSION['register'] = true;
                header("Location: register2.php");
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

    if (isset($_POST['verzendCode'])){
        $codeVerzonden = true;
        $_SESSION['pogingen'] = 0;
        deleteVerificatieRij($email,$type);
        VerificatieCodeProcedure($email, $type);
        $code = HaalVerficatiecodeOp($email, $type);
        StuurRegistreerEmail($email, $code);
    }
?>

<div class="container">
    <div class="row">
        <div class="offset-3 col-md-6 mt-4 border border-dark rounded">
            <form class="needs-validation " novalidate action='validatie.php' method="post">
                <h1 class="h3 mb-4 mt-2 text-center "> Validatie </h1>
                <p> Er wordt een validatiecode verstuurd naar het ingevoerde emailadres. <br> <br>
                    Voer hier de validatiecode in om uw registratie te voltooien: </p>
                <?php
    if($codeVerzonden){
        echo '<div class="form-row">
                            <div class="alert alert-success" role="alert">
                              <strong>Nieuwe code is verzonden!</strong> Er is een nieuwe code verzonden naar het emailadres.
                              </div>
                            </div>';}

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
                    <button class="btn btn-lg bg-flame btn-block mb-5 mt-3" id="registreren" type="submit" name="registreren" value="registreren"> Registreer </button>
                    <p> Klik op deze knop als u naar een paar minuten nog geen verificatie mail heeft gekregen: <p>
                    <!-- Button trigger modal -->
                    <button type="submit" class="btn btn-lg bg-flame btn-block" id="verzendCode" name="verzendCode" value="verzendCode" >
                        Verzend Code
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>

<?php
}
else{
    include 'includes/404error.php';
}
include 'includes/footer.php';
?>
