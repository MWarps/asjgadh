<?php include 'includes/header.php'?>

<div class="container">
    <div class="offset-md-3">
        <h1>Wachtwoord resetten <span class="h3 mb-3 font-weight-normal"></span></h1>
<!-- hieronder wordt de tekst en invulveld voor de gebruikersnaam gemaakt -->
        <div class="form-row">
            <div class="form-group col-md-6">  
                <label for="inputGebruikersnaam">Gebruikersnaam</label>
                <input type="text" class="form-control" id="gebruikersnaam" placeholder="Gebruikersnaam">
            </div>
        </div>
<!-- hieronder wordt de veiliheidsvraag geselecteerd -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="selecteerVeiligheidsvraag">Selecteer je Veiligheidsvraag</label>
                <select class="Veiliheidsvraag form-control">
                    <option selected>Selecteer</option>
                    <option value="1">In welke straat ben je geboren?</option>
                    <option value="2">Wat is de meisjesnaam van je moeder?</option>
                    <option value="3">Wat is je lievelingsgerecht?</option>
                    <option value="4">Hoe heet je oudste zusje?</option>
                    <option value="5">Hoe heet je huisdier?</option>
                </select>
            </div>
        </div>
<!-- hieronder wordt de veiliheidsvraag beantwoord -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="antwoordVeiligheidsvraag">Antwoord op veiligheidsvraag</label>
                <input type="text" class="form-control" id="antwoordVeiligheidsvraag" placeholder="Antwoord">
            </div>
        </div>
<!-- hieronder wordt het nieuwe wachtwoord gegeven (X2) -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="antwoordVeiligheidsvraag">Nieuw wachtwoord</label>
                <input type="password" class="form-control" id="nWachtwoord1" placeholder="Wachtwoord">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="antwoordVeiligheidsvraag">Herhaal nieuw wachtwoord</label>
                <input type="password" class="form-control" id="nWachtwoord2" placeholder="Wachtwoord">
            </div>
        </div>
<!-- hier wordt de reset button gemaakt. -->
        <div class="offset-md-2">
        <div class="form-row">
            <button class="btn btn-primary" type="submit">Reset</button>
        </div>
    </div>
    </div>
</div>
<?php include 'includes/footer.php'?>

