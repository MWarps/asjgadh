<?php
include 'includes/header.php';
$pagina = 'catalogus.php';
setupCatogorien();
// Kijkt er geklikt is op de knop uitloggen
if (isset($_GET['uitlog'])){
    $_SESSION['status'] = $_GET['uitlog'];
    session_unset();
    session_destroy();
    $url = 'index.php';
    echo '<script language="javascript">window.location.href ="'.$url.'"</script>';
    die();
}

// Geeft een melding a.d.h.v de status
if(isset($_SESSION['status'])){

    switch ($_SESSION['status']) {
        case 'login':
            $status = 'U bent ingelogd!';
            break;
        case 'registreren':
            $status = 'U bent geregistreerd!';
            break;
        case 'wachtwoordreset':
            $status = 'U wachtwoord is veranderd!';
            break;
        case 'verkoper':
            $status = 'U bent geregistreerd als verkoper';
        default:
            // code...
            break;
    }

    unset($_SESSION['status']);

    // laat melding zien aan gebruiker
    echo '<div class="container">
            <div class="h-100 row align-items-center">
              <div class="col">
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                          <strong>'.$status.'</strong> U kunt op het kruisje klikken om deze melding te sluiten.
                          <button type="button" class="close pt-0" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            </div>
                          </div>
                       </div>
                      ';
}
?>
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="img-wrap-index">
            <img src="assets/img/fantasy-1.jpg" alt="...">
          </div>
            <div class="carousel-caption d-none d-md-block">
                <h5>...</h5>
                <p>...</p>
            </div>
        </div>
        <div class="carousel-item">
          <div class="img-wrap-index">
            <img src="assets/img/fantasy-2.jpg" alt="...">
            <div class="carousel-caption d-none d-md-block">
                </div>
                <h5>...</h5>
                <p>...</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/img/fantasy-4.jpg" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>...</h5>
                <p>...</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/img/fantasy-5.jpg" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>...</h5>
                <p>...</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/img/fantasy-6.jpg" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>...</h5>
                <p>...</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/img/fantasy-7.jpg" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>...</h5>
                <p>...</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="container-fluid">
    <div class="row mt-2">
     <div class="col-md-3">
            <div class="card bg-light mb-3">
                <div class="card-header bg-orange2 text-white text-uppercase"><i class="fa fa-list"></i> categorie&euml;n </div>
                <button class="dropdown-menu card-header bg-orange2 text-white text-uppercase">categorie</button>
                <?php    directorieVinden($pagina) ?>
            </div>
        </div>
    <!--/span-->

    <div class="col-md-9">
    <div class="row">
        <?php if (isset($_SESSION['gebruikersnaam'])) {?>
        <button type="button" class="btn btn-secondary btn-sm btn-block">Laatst Bekeken</button>
        <?php $laatstBekeken = getLaatstBekeken($_SESSION['gebruikersnaam']); ?>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?php $advertentie = DetailAdvertentie($laatstBekeken[0]); ?>
            <div class="hovereffect">
                <img class="img-responsive" src="<?php echo $advertentie['illustratieFile']?>" alt="">
                <div class="overlay">
                    <h2>Hover effect 1</h2>
                    <a class="info" href=\"advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?php $advertentie = DetailAdvertentie($laatstBekeken[1]); ?>
            <div class="hovereffect">
                <img class="img-responsive" src="<?php echo $advertentie['illustratieFile'];?>" alt="">
                <div class="overlay">
                    <h2>Hover effect 1</h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?php $advertentie = DetailAdvertentie($laatstBekeken[2]);?>
            <div class="hovereffect">
                <img class="img-responsive" src="<?php echo $advertentie['illustratieFile'];?>" alt="">
                <div class="overlay">
                    <h2>Hover effect 1</h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary btn-sm btn-block">Aanbevolen</button>
        <?php
        $rubriek = getAanbevolen($_SESSION['gebruikersnaam']);
        $aanbevolen = getProductenUitRubriek($rubriek, 3);
        ?>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?php $advertentie = DetailAdvertentie($aanbevolen[0]);?>
            <div class="hovereffect">
                <img class="img-responsive" src="<?php echo $advertentie['illustratieFile'];?>" alt="">
                <div class="overlay">
                    <h2>Hover effect 1</h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?php $advertentie = DetailAdvertentie($aanbevolen[1]);?>
            <div class="hovereffect">
                <img class="img-responsive" src="<?php echo $advertentie['illustratieFile'];?>" alt="">
                <div class="overlay">
                    <h2>Hover effect 1</h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?php $advertentie = DetailAdvertentie($aanbevolen[2]);?>
            <div class="hovereffect">
                <img class="img-responsive" src=\"<?php echo $advertentie['illustratieFile'];?>" alt="">
                <div class="overlay">
                    <h2>Hover effect 1</h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
        <?php }?>
        <button type="button" class="btn btn-secondary btn-sm btn-block">Populairste Artikelen</button>
        <?php $populairst = getPopulairsteArtikelen(); ?>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?php $advertentie = DetailAdvertentie($populairst[0]);?>
            <div class="hovereffect">
                <img class="img-responsive" src="<?php echo $advertentie['illustratieFile'];?>" alt="">
                <div class="overlay">
                    <h2>Hover effect 1</h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?php $advertentie = DetailAdvertentie($populairst[1]);?>
            <div class="hovereffect">
                <img class="img-responsive" src="<?php echo $advertentie['illustratieFile'];?>" alt="">
                <div class="overlay">
                    <h2>Hover effect 1</h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?php $advertentie = DetailAdvertentie($populairst[2]);?>
            <div class="hovereffect">
                <img class="img-responsive" src="<?php echo $advertentie['illustratieFile'];?>" alt="">
                <div class="overlay">
                    <h2>Hover effect 1</h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
    </div>
</div><!--/row-->
</div><!--/.container-->

<?php include 'includes/footer.php' ?>
