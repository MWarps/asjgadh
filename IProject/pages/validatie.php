<?php
include '../includes/header.php';

  /* function stuur email*/
if (isset($_POST['registeren'])){
  echo 'test';
}
      /* functie controleer code
      if ($code == $_POST['validatie'])
      else{ $foutInvoer++;
      echo 'foute invoer probeer opnieuw';
      // wachtwoord word gehashed
           $hashedWachtwoord = password_hash($rWachtwoord, PASSWORD_DEFAULT);

           try {
             // SQL insert statement
               $sqlInsert = $dbh->prepare("INSERT INTO Gebruiker (
                  gebruikersnaam, voornaam, achternaam, adresregel1,
                  postcode, plaatsnaam, land, geboortedatum, email,
                  wachtwoord, vraag, antwoordtekst, verkoper)
                 values (
                   :rGebruikersnaam, :rVoornaam, :rAchternaam, :rAdresregel1,
                   :rPostcode, :rPlaatsnaam, :rLand, :rGeboortedatum, :rEmail,
                   :rWachtwoord, :rVraag, :rAntwoordtekst, :rVerkoper)");

               $sqlInsert->execute(
                   array(
                       ':rGebruikersnaam' => $rGebruikersnaam,
                       ':rVoornaam' => $rVoornaam,
                       ':rAchternaam' => $rAchternaam,
                       ':rAdresregel1' => $rStraat,
                       ':rPostcode' => $Postcode,
                       ':rPlaatsnaam' => $rPlaats,
                       ':rLand' => $Land,
                       ':rGeboortedatum' => $rGeboorte,
                       ':rEmail' => $rEmail,
                       ':rWachtwoord' => $hashedWachtwoord,
                       ':rVraag' => $rGeheimV,
                       ':rAntwoordtekst' => $rGeheimA,
                       ':rVerkoper' => $Verkoper

                   ));
           } catch (PDOexception $e) {
               echo "er ging iets mis {$e->getMessage()}";
           }


       }
   }
   }
   */
?>
<div class="container">
  <div class="row">
      <div class="offset-3 col-md-6 mt-4">
        <div class="jumbotron bg-dark text-white">
          <form class="needs-validation" novalidate action='validatie.php' method="post">
              <h1 class="h3 mb-4 text-center "> Validatie </h1>
              <div class="form-row">

                <p>  Er wordt een validatie code verstuurd naar het ingevoerde emailadres. <br> <br>
                  Voer hier de validatie code in om uw registratie te voltooien: </p>

                <div class="input-group mb-3">
                  <input type="text" name="validatie" class="form-control mb-3" id="inputValidatie" placeholder="Voer hier uw code in" required>
                  <button class="btn btn-lg bg-flame btn-block" type="submit" name="registreren"> registreer </button>
                </div>

              </div>
          </form>
        </div>
      </div>
  </div>
</div>
<?php include '../includes/footer.php'?>
