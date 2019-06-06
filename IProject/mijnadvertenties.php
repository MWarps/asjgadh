<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
geen problemen gevonden
*/
include 'includes/header.php';

if(isset($_SESSION['gebruikersnaam'])){
  $verwijderen = false;
  $verkocht = false;


if(isset($_GET['id'])){
  if($_GET['status'] == 'verkopen'){
    VerkoopVeiling($_GET['id']);
    $Veiling = HaalBiederEnVerkoperOp($_GET['id'], $_SESSION['gebruikersnaam']);
    VerstuurVerkoopMail($Veiling);
    $verkocht = true;
  }
  if($_GET['status'] == 'verwijderen'){
    $Veiling = HaalBiederEnVerkoperOp($_GET['id'], $_SESSION['gebruikersnaam']);
    VerwijderVeiling($_GET['id']); 
    VerstuurVerwijderMail($Veiling, false);
    
    if(count($Veiling) == 3){
    VerstuurVerwijderMail($Veiling, true);
    }
    $verwijderen = true;
  }
}  


?>

<div class="container-fluid">
    <div class="col">
      <div class="row mt-2">    
        <?php if($verwijderen){
          $verwijderen = false;      
          // laat melding zien aan gebruiker
          echo '<div class="container">
                  <div class="h-100 row align-items-center">
                    <div class="col">
                              <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                <strong>Het voorwerp is verwijderd!</strong> U kunt op het kruisje klikken om deze melding te sluiten.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                      </div>
                    </div>
                  </div>';
        }
        if($verkocht){
          $verkocht = false;      
          // laat melding zien aan gebruiker
          echo '<div class="container">
                  <div class="h-100 row align-items-center">
                    <div class="col">
                              <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                <strong>Het voorwerp is Verkocht!</strong> U kunt op het kruisje klikken om deze melding te sluiten.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                      </div>
                    </div>
                  </div>';
        }
        ?>  
              <button type="button" class="btn btn-secondary btn-sm btn-block">Mijn advertenties</button>
                <?php 
                $advertenties = HaalMijnAdvertentieOp($_SESSION['gebruikersnaam']);
                $knop = '';
                $verkocht = false;
                if(!empty($advertenties)){ 
                foreach ($advertenties as $rij) {
                    $details = DetailAdvertentieMijnAdvertenties($rij['voorwerpnr']);
                    $locatie = '../pics/';
                    
                    $hoogstebieder = zijnErBiedingen($details['voorwerpnr']);
                    $hoogstbieder = $hoogstebieder['euro'];
                    
                    if(!empty($hoogstbieder)){
                      $details['startprijs'] = $hoogstbieder;
                    }    
                    
                    if(substr($details['illustratieFile'] , 0 ,2 ) == 'ea'){
                        $locatie = 'upload/';
                    } 
                    if(strlen($details['titel']) >= 40){
                        $details['titel'] = substr($details['titel'],0,40);
                        $details['titel'] .= '...';
                    }
                    $Bieder = HaalBiederEnVerkoperOp($details['voorwerpnr'], $_SESSION['gebruikersnaam']);
                    $artikelKnop = '<a href="advertentie.php?id='.$details['voorwerpnr'].'" class="btn btn-block btn-primary py-2">Ga naar artikel</a>';
                    $verkocht = '<a class="btn btn-block btn-success py-2 '.$knop.'" href="mijnadvertenties.php?id='.$details['voorwerpnr'].'&status=verkopen" >Verkopen</a>';
                    
                    if(count($Bieder) == 2){
                      echo 'test';                
                      $knop = 'disabled';                  
                    }          
                    if(count($Bieder) == 3){
                    if(!empty($Bieder[2]['koper'])){
                      echo 'test';
                      $knop = 'disabled';
                      $verkocht = '<button type="button" class="btn btn-block btn-success py-2 '.$knop.'" >Advertentie is verkocht</button>';
                      $artikelKnop = '';
                    }}
                    
                    
                    
                    echo '
                    <div class="col-md-3 p-2">
                      <div class="card">
                       <div class="card-img-boven">
                        <img src="'.$locatie.$details['illustratieFile'].'" alt="Foto bestaat niet">
                       </div> 
                      <h5 class="card-header">'.$details['titel'].'</h5>
                        <div class="card-body">
                          <h4 class="card-text">€ '.number_format($details['startprijs'], 2, ',', '.').'</h4>
                          <p class="card-text"><a href="#">'.$details['verkoper'].'</a><br>
                          '.$details['land'].', '.$details['plaatsnaam'].'</p>
                          '.$artikelKnop.'                                                                         
                          '.$verkocht.'
                          <a class="btn btn-block btn-danger py-2" href="mijnadvertenties.php?id='.$details['voorwerpnr'].'&status=verwijderen">Verwijderen</a>
                          
                        </div>
                      </div>
                    </div>';
        
                }
              }
              else{
                echo '
                <div class="container">
                 <div class="h-100 row align-items-center py-2">
                  <div class="col">
                    <div class="alert alert-success" role="alert">
                      <strong>U heeft nog geen advertenties geplaatst!</strong> Klik op veilen om een voorwerp te plaatsen.
                    </div>
                  </div>
                 </div>
                </div>';
              }
                ?>
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
