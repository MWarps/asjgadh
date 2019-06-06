<?php
/*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
eerste validatie:
warinings:
- er stond ergen ?>> in plaats van ?>

oplossingen:
- ?>> veranderd naar ?>

tweede validatie:
geen problemen gevonden
*/
include 'includes/header.php';
if(isset($_GET['id'])){
    $gebruikersnaam = $_SESSION['gebruikersnaam'];
    $advertentie = DetailAdvertentie($_GET['id']);
    $bieden = true;
    if($advertentie['verkoper'] == $_SESSION['gebruikersnaam']){
        $bieden = false;
    }
    $pagina = 'advertentie.php';
    if(!isset($_POST['bieden'])){
        $voorwerpnr = $_GET['id'];

        VoorwerpGezien($voorwerpnr);

        if(isset($_SESSION['gebruikersnaam'])){
            gebruikerBekeekVoorwerp($gebruikersnaam, $voorwerpnr);
            gebruikerAanbevolen($gebruikersnaam, $voorwerpnr);
        }
    }

    if(isset($_POST['bieden'])){
        if(isset($_SESSION['gebruikersnaam'])){
            $bod = $_POST['bod'];
            $voorwerpnr = $_GET['id'];
            updateBieden($bod, $gebruikersnaam, $voorwerpnr);
        }
        else {
            echo '<div class="container">
            <div class="h-100 row align-items-center">
              <div class="col">
                 <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                    <strong>U bent niet ingelogd</strong> U Moet eerst inloggen voordat u een bod kan uitbrengen.
                      <button type="button" class="close pt-0" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                 </div>
              </div>
            </div>
          </div>';
        }
    }
    ?>

    <!-- Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3><?php echo $advertentie['titel']; ?></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7" >
                <iframe width="100%" height="450px" srcdoc='<html><body><?php echo $advertentie['beschrijving']; ?></body></html>'></iframe>
            </div>
            <div class="col-md-5">
                <div class="gallery-wrap" >
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">

                            <?php
                            $Illustratie1 = HaalIllustratiesOp($advertentie['voorwerpnr']);

                            $teller = 0;
                            foreach ($Illustratie1 as $rij) {
                                $locatie = '../pics/';
                                if(substr($rij['illustratieFile'] , 0 ,2 ) == 'ea'){
                                    $locatie = 'upload/';
                                }
                                if(!empty($rij['illustratieFile'])){
                                    echo '<li data-target="#carousel-example-generic" data-slide-to="'.$rij.'"><img src="'.$locatie.$rij['illustratieFile'].'" alt="..."></li>';
                                    $teller++;
                                }  }
                            ?>
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <div class="img-big-wrap">
                                    <img src="<?php
                                    $locatie = '../pics/';
                                    if(substr($rij['illustratieFile'] , 0 ,2 ) == 'ea'){
                                        $locatie = 'upload/';
                                    }  echo $locatie.$Illustratie1[0]['illustratieFile'] ?>" alt="...">
                                </div>
                            </div>
                            <?php                            
                            for ($teller = 1; $teller < count($Illustratie1); $teller++) {
                                $locatie = '../pics/';
                                if(substr($rij['illustratieFile'] , 0 ,2 ) == 'ea'){
                                    $locatie = 'upload/';
                                }                                
                                    echo '<div class="carousel-item">
                                            <div class="img-big-wrap">
                                              <img src="'.$locatie.$Illustratie1[$teller]['illustratieFile'].'" alt="...">
                                            </div>           
                                          </div>';                                    
                                 }
                            ?>
                        </div>
                        <!-- Controls -->
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <form class="needs-validation" novalidate action='advertentie.php?id=<?php echo $advertentie['voorwerpnr']?>' method="post">
                    <div class="form-row">
                        <?php if(!empty(zijnErBiedingen($advertentie['voorwerpnr']))) {
                            $hoogstebod = zijnErBiedingen($advertentie['voorwerpnr']);
                            $verhoging = BodVerhoging($hoogstebod['euro']);
                            $hoogstebod = $hoogstebod['euro'] + $verhoging;
                            $hoogstebod1 = number_format($hoogstebod, 2, ',', '.');
                        }

                        else {  $hoogstebod = $advertentie['startprijs'];
                            $hoogstebod1 = number_format($advertentie['startprijs'], 2, ',', '.');
                        }
                        ?>
                        <label for="bod">Bieden: (vanaf: €<?php echo $hoogstebod1; ?>)</label>
                        <input type="number" name="bod" class="form-control" id="bod" step="0.01" max="999999.99" min="<?php echo $hoogstebod; ?>"<?php if($bieden){echo 'required';} else{ echo 'readonly';} ?> >
                        <div class="invalid-feedback">
                            Voer een bod vanaf €<?php echo $hoogstebod1; ?>.
                        </div>
                        <?php if($bieden){echo '<button class="btn btn-lg btn-primary mt-3" type="submit" name="bieden" value="bieden"> Plaats bod </button>';} ?>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-orange2">Biedingen</li>
                    <?php if(empty(zijnErBiedingen($advertentie['voorwerpnr']))){
                        echo '<li class="list-group-item"> Er zijn nog geen biedingen gedaan</li>';}
                    if(!empty(zijnErBiedingen($advertentie['voorwerpnr']))){
                        Biedingen($advertentie['voorwerpnr']);}
                    ?>
                </ul>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        Gebruiker Informatie
                    </div>
                    <div class="card-body">
                      Naam: <strong><?php echo $advertentie['verkoper']; ?></strong><br>
                      <?php $recenties = haalRecentieOp($advertentie['verkoper']); 
                            if(!empty($recenties[0]['recentie'])){
                              ?> 
                        
                        Reviews:<br><br>
                        
                            <h1><?php echo 'Gemiddelde: '.$recenties[1]['recentie'].'/10' ?> </h1>
                            <p><?php echo 'Aantal recenties: '.$recenties[0]['recentie'].'' ?> </p>
                          
                          <?php }
                                else{
                                  echo '<h4> Deze verkoper heeft nog geen recenties </h4>';
                                }                                              ?>
                        
                        <button type="button" class="btn btn-primary btn-lg mt-3"><a style="color: white;" href="stuurbericht.php?id=<?php echo $advertentie['verkoper']?>">Stuur bericht!</a></button>
                    </div>
                </div>
                <hr>
                <div class="icon-product">
                    <img src="assets/img/oog.jpg"> <?php echo $advertentie['gezien'] ?> x Bekeken <br>
                    <img src="assets/img/clock.jpg"> sinds <?php echo date("d.m.Y H:i", strtotime($advertentie['looptijdbegindagtijdstip'])); ?>  <br><br>
                    <img src="assets/img/betalingswijze.png"> betalingswijze: <strong><?php echo $advertentie['betalingswijze'] ?></strong> <br>
                    <img src="assets/img/instructions.png"> betalingsinstructies: <?php echo $advertentie['betalingsinstructie'] ?> <br><br>
                    <img src="assets/img/verzending.png"> Verzendkosten: <?php echo $advertentie['verzendkosten'] ?> <br>
                    <img src="assets/img/instructions.png"> Verzendinstructies: <?php echo $advertentie['verzendinstructies'] ?> <br><br>
                    <img src="assets/img/voorwerp.png"> Voorwerpnummer: <strong><?php echo $advertentie['voorwerpnr'] ?></strong>
                </div>
            </div>
        </div>
    </div>
<?php }
else {
    include 'includes/404error.php';
}

include 'includes/footer.php' ?>
