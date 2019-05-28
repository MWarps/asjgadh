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
        <?php $laatstBekeken = getLaatstBekeken($_SESSION['gebruikersnaam']);
        if(empty($laatstBekeken)){ ?>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <p> U heeft nog geen adverties bekeken </p>
          </div>
      <?php }
      if(!empty($laatstBekeken)) {?>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?php $advertentie = DetailAdvertentie($laatstBekeken[0]['voorwerpnr']);
             ?>
            <div class="hovereffect">
                <img class="img-responsive" src="../pics/<?php echo $advertentie['illustratieFile']?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?php $advertentie = DetailAdvertentie($laatstBekeken[1]['voorwerpnr']);?>
            <div class="hovereffect">
                <img class="img-responsive" src="../pics/<?php echo $advertentie['illustratieFile'];?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
      
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?php $advertentie = DetailAdvertentie($laatstBekeken[2]['voorwerpnr']);?>
            <div class="hovereffect">
                <img class="img-responsive" src="../pics/<?php echo $advertentie['illustratieFile'];?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
        <?php } ?>
        <button type="button" class="btn btn-secondary btn-sm btn-block">Aanbevolen</button>
        
        <?php
        $rubriek = getAanbevolen($_SESSION['gebruikersnaam']);         
        $aanbevolen = getProductenUitRubriek2($rubriek['rubrieknr'], 3);
        if(empty($aanbevolen)){ ?>
         <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
           <p> U heeft nog geen aanbevolen advertenties </p>
         </div>
       <?php }
       if(!empty($aanbevolen)) {?>
        
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-2">
            <?php $advertentie = DetailAdvertentie($aanbevolen[0]['voorwerpnr']);?>
            <div class="hovereffect">
                <img class="img-responsive" src="../pics/<?php echo $advertentie['illustratieFile'];?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-2">
            <?php $advertentie = DetailAdvertentie($aanbevolen[1]['voorwerpnr']);?>
            <div class="hovereffect">
                <img class="img-responsive" src="../pics/<?php echo $advertentie['illustratieFile'];?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-2">
            <?php $advertentie = DetailAdvertentie($aanbevolen[2]['voorwerpnr']);?>
            <div class="hovereffect">
                <img class="img-responsive" src=../pics/"<?php echo $advertentie['illustratieFile'];?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>"><?php echo $advertentie['titel'];?></a>
                </div>
            </div>
        </div>
      <?php }}?>
        <button type="button" class="btn btn-secondary btn-sm btn-block">Populairste Artikelen</button>
        <?php $populairst = getPopulairsteArtikelen();
        //print_r($populairst); ?>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
            <?php $advertentie = DetailAdvertentie($populairst[0]['voorwerpnr']);
            //print_r($advertentie);?>
            <div class="hovereffect">
                <img class="img-responsive" src="../pics/<?php echo $advertentie['illustratieFile'];?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>">€ <?php echo $advertentie['startprijs'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
            <?php $advertentie = DetailAdvertentie($populairst[1]['voorwerpnr']);
            //print_r($advertentie);?>
            <div class="hovereffect">
                <img class="img-responsive" src="../pics/<?php echo $advertentie['illustratieFile'];?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>">€ <?php echo $advertentie['startprijs'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
            <?php $advertentie = DetailAdvertentie($populairst[2]['voorwerpnr']);
            //print_r($advertentie);?>
            <div class="hovereffect">
                <img class="img-responsive" src="../pics/<?php echo $advertentie['illustratieFile'];?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>">€ <?php echo $advertentie['startprijs'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
            <?php $advertentie = DetailAdvertentie($populairst[3]['voorwerpnr']);
            //print_r($advertentie);?>
            <div class="hovereffect">
                <img class="img-responsive" src="../pics/<?php echo $advertentie['illustratieFile'];?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>">€ <?php echo $advertentie['startprijs'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
            <?php $advertentie = DetailAdvertentie($populairst[4]['voorwerpnr']);
            //print_r($advertentie);?>
            <div class="hovereffect">
                <img class="img-responsive" src="../pics/<?php echo $advertentie['illustratieFile'];?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>">€ <?php echo $advertentie['startprijs'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
            <?php $advertentie = DetailAdvertentie($populairst[5]['voorwerpnr']);
            //print_r($advertentie);?>
            <div class="hovereffect">
                <img class="img-responsive" src="../pics/<?php echo $advertentie['illustratieFile'];?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>">€ <?php echo $advertentie['startprijs'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
            <?php $advertentie = DetailAdvertentie($populairst[6]['voorwerpnr']);
            //print_r($advertentie);?>
            <div class="hovereffect">
                <img class="img-responsive" src="../pics/<?php echo $advertentie['illustratieFile'];?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>">€ <?php echo $advertentie['startprijs'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
            <?php $advertentie = DetailAdvertentie($populairst[7]['voorwerpnr']);
            //print_r($advertentie);?>
            <div class="hovereffect">
                <img class="img-responsive" src="../pics/<?php echo $advertentie['illustratieFile'];?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>">€ <?php echo $advertentie['startprijs'];?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
            <?php $advertentie = DetailAdvertentie($populairst[8]['voorwerpnr']);
            //print_r($advertentie);?>
            <div class="hovereffect">
                <img class="img-responsive" src="../pics/<?php echo $advertentie['illustratieFile'];?>" alt="Geen afbeelding beschikbaar">
                <div class="overlay">
                    <h2><?php echo $advertentie['titel'];?></h2>
                    <a class="info" href="advertentie.php?id=<?php echo $advertentie['voorwerpnr']; ?>">€ <?php echo $advertentie['startprijs'];?></a>
                </div>
            </div>
        </div>
      
    </div>
</div><!--/row-->
</div><!--/.container-->

<?php include 'includes/footer.php'; ?>
