<?php
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
                                    echo '<li data-target="#carousel-example-generic" data-slide-to="'.$teller.'"><img src="'.$locatie.$rij['illustratieFile'].'" alt="..."></li>';
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
                            $teller = 1;

                            foreach ($Illustratie1 as $rij) {
                                $locatie = '../pics/';
                                if(substr($rij['illustratieFile'] , 0 ,2 ) == 'ea'){
                                    $locatie = 'upload/';
                                }
                                if(!empty($rij['illustratieFile'])){
                                    echo '<div class="carousel-item">
                    <div class="img-big-wrap">
                      <img src="'.$locatie.$Illustratie1[$teller]['illustratieFile'].'" alt="...">
                    </div>           
                 </div>';
                                    $teller++;
                                } }
                            ?>
                        </div>
                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
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
                        <input type="number" name="bod" class="form-control" id="bod" step="0.01" min="<?php echo $hoogstebod; ?>"<?php if($bieden){echo 'required';} else{ echo 'readonly';} ?>>
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
            <div class="col-md-5 text-center">
                <div class="card">
                    <div class="card-header">
                        Gebruiker Informatie
                    </div>
                    <div class="card-body">
                        <a href="#"><?php echo $advertentie['verkoper']; ?></a><br>
                        <a href="#">Reviews</a><br><br>
                        <div class="col-xs-12 col-md-6 text-center">
                            <h1 class="rating-num">
                                4.0</h1>
                            <div class="rating">
                                <span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star">
                            </span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star">
                            </span><span class="glyphicon glyphicon-star-empty"></span>
                            </div>
                            <div>
                                <span class="glyphicon glyphicon-user"></span>1,050,008 total
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="row rating-desc">
                                <div class="col-xs-3 col-md-3 text-right">
                                    <span class="glyphicon glyphicon-star"></span>5
                                </div>
                                <div class="col-xs-8 col-md-9">
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80%</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- end 5 -->
                                <div class="col-xs-3 col-md-3 text-right">
                                    <span class="glyphicon glyphicon-star"></span>4
                                </div>
                                <div class="col-xs-8 col-md-9">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60%</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- end 4 -->
                                <div class="col-xs-3 col-md-3 text-right">
                                    <span class="glyphicon glyphicon-star"></span>3
                                </div>
                                <div class="col-xs-8 col-md-9">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40%</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- end 3 -->
                                <div class="col-xs-3 col-md-3 text-right">
                                    <span class="glyphicon glyphicon-star"></span>2
                                </div>
                                <div class="col-xs-8 col-md-9">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20%</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- end 2 -->
                                <div class="col-xs-3 col-md-3 text-right">
                                    <span class="glyphicon glyphicon-star"></span>1
                                </div>
                                <div class="col-xs-8 col-md-9">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80"
                                             aria-valuemin="0" aria-valuemax="100" style="width: 15%">
                                            <span class="sr-only">15%</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- end 1 -->
                            </div>
                            <!-- end row -->
                        </div>
                        <button type="button" class="btn btn-primary btn-lg"><a style="color: white;" href="stuurbericht.php?id=<?php echo $advertentie['verkoper']?>">Stuur bericht!</a></button>
                    </div>
                </div>
                <hr>
                <div class="icon-product">
                    <img src="assets/img/oog.jpg"></img> <?php echo $advertentie['gezien'] ?> x Bekeken <br>
                    <img src="assets/img/clock.jpg"></img>  sinds <?php echo date("d.m.Y H:i", strtotime($advertentie['looptijdbegindagtijdstip'])); ?>  <br><br>
                    <img src="assets/img/betalingswijze.png"></img>  betalingswijze: <strong><?php echo $advertentie['betalingswijze'] ?></strong> <br>
                    <img src="assets/img/instructions.png"></img>  betalingsinstructies: <?php echo $advertentie['betalingsinstructie'] ?> <br><br>
                    <img src="assets/img/verzending.png"></img>  Verzendkosten: <?php echo $advertentie['verzendkosten'] ?> <br>
                    <img src="assets/img/instructions.png"></img>  Verzendinstructies: <?php echo $advertentie['verzendinstructies'] ?> <br><br>
                    <img src="assets/img/voorwerp.png"></img>  Voorwerpnummer: <strong><?php echo $advertentie['voorwerpnr'] ?></strong>
                </div>
            </div>
        </div>
    </div>
<?php }
else {
    include 'includes/404error.php';
}

include 'includes/footer.php' ?>
