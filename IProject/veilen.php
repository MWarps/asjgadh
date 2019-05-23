<?php
include 'includes/header.php';
?>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 mt-2">
            <div class="needs-validation" novalidate action='veilen.php' method="post">
                <h1 class="h3 mb-2 text-center "> Veiling starten </h1>
                <p class=" mb-2 text-center " > Hier kunt u een voorwerp te koop aan bieden, vul alle onderstaande velden in.</p>

                <div class="form-row">
                    <div class="form-group col-md-10">
                        <label for="inputTitel">Titel</label>
                        <p> Vul een titel in. Denk aan belangrijke eigenschappen zoals kleur, merk of maat</p>
                        <input type="text" name="rTitel" class="form-control" id="inputTitel"
                               pattern="[a-zA-Z]*" maxlength="100" placeholder="Titel" value="<?php if($_POST) { echo $_POST['rTitel'];} ?>" required>
                        <div class="invalid-feedback">
                            Voer een titel in.
                        </div>
                    </div>

                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

                    <style>
                        .dropdown-submenu {
                            position: relative;
                        }

                        .dropdown-submenu .dropdown-menu {
                            top: 0;
                            left: 100%;
                            margin-top: -1px;
                        }
                    </style>

                    <div class="container">
                        <label for = "inputRubriek"> Rubriek</label>
                        <p>Kies een rubriek</p>
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Rubriek
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a class="test" tabindex="-1" href="#">Rubriek uit database1 <span class="caret"></span></a>
                                    <a class="test" tabindex="-2" href="#">Rubriek uit database2 <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a tabindex="-1" href="#">SubRubriek</a></li>
                                        <li><a tabindex="-1" href="#">SubRubriek</a></li>
                                        <li class="dropdown-submenu">
                                            <a class="test" href="#">Subriebriek<span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">subsub</a></li>
                                                <li><a href="#">subsub</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <script>
                        $(document).ready(function(){
                            $('.dropdown-submenu a.test').on("click", function(e){
                                $(this).next('ul').toggle();
                                e.stopPropagation();
                                e.preventDefault();
                            });
                        });
                    </script>


                    <div class="form-group col-md-4">
                        <label for="inputBeschrijving">Beschrijving</label>
                        <textarea   <input type="text" name="rBeschrijving" class="form-control" id="inputBeschrijving" rows="6" placeholder="Beschrijving"
                               pattern="[A-Za-z]*" maxlength="250" value="<?php if($_POST) { echo $_POST['rBeschrijving'];} ?>" required>

                        </textarea>
                        <div class="invalid-feedback">
                            Voer een beschrijving in.
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-4">
                        <form>
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Voeg minimaal 1 afbeelding toe</label>
                                <input type="file" class="form-control-file pb-4" id="exampleFormControlFile1" required>
                                <label for="exampleFormControlFile2"></label>
                                <input type="file" class="form-control-file pb-4" id="exampleFormControlFile1">
                                <label for="exampleFormControlFile2"></label>
                                <input type="file" class="form-control-file pb-4" id="exampleFormControlFile1">
                                <label for="exampleFormControlFile2"></label>
                                <input type="file" class="form-control-file pb-4" id="exampleFormControlFile1">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputStartbedrag">Startbedrag in euro's</label>
                        <input type="number" min="0" name="rStartbedrag" class="form-control" id="inputStartbedrag" placeholder="€..."
                               pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,49}$" maxlength="5" value="<?php if($_POST) { echo $_POST['rStartbedrag'];} ?>" required>
                        <div class="invalid-feedback">
                            Voer een geldig startbedrag in, dit getal moet hoger zijn dan 0.
                        </div>
                    </div>
                </div>


                <div class="form-row">

                    <div class="form-group col-md-4">

                        <label for="inputBetalingsmethode">Gewenste betalingsmethode</label>
                        <select name="rBetalingsmethode" class="form-control" id="inputBetalingsmethode" value="<?php if($_POST) { echo $_POST['rBetalingsmethode'];} ?>" required>
                            <option value="Contant"> Contant </option>
                            <option value="iDeal"> iDeal </option>
                            <option value="Paypal"> Paypal </option>
                        </select>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputLooptijd">Looptijd</label>
                        <form action="idk" method="get">
                        <button class="btn btn-primary" type="submit" value="5">5 dagen</button>
                        <button class="btn btn-primary" type="submit" value="7">7 dagen</button>
                        <button class="btn btn-primary" type="submit" value="10">10 dagen</button>
                        </form>
                    </div>
                </div>



                <div class="form-row">
                    <div class="form-group">
                        <div class="form-check">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" value="" id="defaultUnchecked" required>
                                <label class="custom-control-label" for="defaultUnchecked">
                                    Ga akkoord met de algemene voorwaarden.
                                </label>
                                <div class="invalid-feedback">
                                    U moet akkoord gaan met onze algemene voorwaarden voordat u kan registreren.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" name="rVolgende" id="rVolgende" class="btn bg-flame">
                    Volgende
                </button>

            </form>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>

