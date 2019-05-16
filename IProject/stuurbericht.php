<?php
include 'includes/header.php';
if (!isset($_SESSON['gebruikersnaam'])){
  
  
?>

<div class="container">
    <div class="row">
        <div class="offset-3 col-md-6 mt-4">
            <form class="needs-validation" novalidate action="stuurbericht.php" method="POST">
                <h1 class="h3 mb-3 text-center">Stuur een bericht!</h1>
                <div class="form-row">
                    <div class="form-group col-md-8">                
                          <label for="rEmail">Van:</label>
                          <input type="text" name="rEmail" class="form-control" id="rEmail" value="<?php //echo $_SESSION['validatie']['email']; ?>" placeholder="<?php //echo $email['email']; ?>"
                           readonly>                      
                    </div>  
                  </div>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="inputTitel">Titel:</label>
                        <input type="text" name="titel" class="form-control" id="inputTitel" placeholder="Titel"
                        required>
                        <div class="invalid-feedback">
                        Voer een titel in.
                        </div>
                    </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                          <label for="Textarea">Bericht:</label>
                          <textarea name="bericht" class="form-control" placeholder="Voer hier uw bericht in." id="Textarea" rows="10"></textarea>
                        </div>
                          <div class="invalid-feedback">
                            Voer een bericht in.
                            </div>
                        </div>  
                <button type="submit" name="rVolgende" id="rVolgende" class="btn bg-flame">
                  Stuur bericht
                </button>
            </form>
        </div>
    </div>
  </div>


<?php
}

else{
  unset($_SESSION['gebruikersnaam']);
    include 'includes/404error.php';
}
include 'includes/footer.php';
?>
