<?php
include 'includes/header.php';
if(isset($_GET['id'])){
$advertentie = DetailAdvertentie($_GET['id']);
$pagina = 'advertentie.php';
if(!isset($_POST['bieden'])){
  $voorwerpnr = $_GET['id']; 
  VoorwerpGezien($voorwerpnr);
}  

if(isset($_POST['bieden'])){
  if(isset($_SESSION['gebruikersnaam'])){
    $bod = $_POST['bod'];
    $gebruikersnaam = $_SESSION['gebruikersnaam'];
    $voorwerpnr = $_GET['id'];  
    updateBieden($bod, $gebruikersnaam, $voorwerpnr);
    //gebruikerBekeekVoorwerp($gebruikersnaam, $voorwerpnr);
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
<div class="container-fluid">
    <div class="row">
        <div class="col">            
            <nav aria-label="breadcrumb">        
                <ol class="breadcrumb">
                  <button class="btn btn-sm btn-primary mr-3" id="terug" name="terug" value="terug"><a href="#"></a>Vorige</button>              
                    <?php catogorieSoort($pagina); ?>                    
                </ol>            
            </nav>
        </div>
    </div>
</div>
<!-- Page Content -->
<div class="container-fluid">
  
<div class="card" style="background-color: #f7f7f6;">
  <div class="row">
    <div class="col">
      <h3 class="card-header"><?PHP echo $advertentie['titel']; ?></h3>
    </div>
  </div>  
  
  <div class="row">
    <div class="col-md-7" >
      <div class="card-body">  
        <iframe width="100%" height="450px" srcdoc='<html><body><?php echo $advertentie['beschrijving']; ?></body></html>'></iframe>
    </div>  <!-- item-property-hor .// -->
  </div>
      
 <!-- gallery-wrap .end// -->

   <div class="col-md-5">
     <div class="gallery-wrap card-body" >
       <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
         <!-- Indicators -->
         <ol class="carousel-indicators">
           <li data-target="#carousel-example-generic" data-slide-to="0" class="active"><img src="../pics/<?php echo $advertentie['illustratieFile']; ?>" alt="..."></li>
           <?php $Illustratie1 = HaalIllustratiesOp($advertentie['voorwerpnr']);
           
           $teller = 1;       
          foreach ($Illustratie1 as $rij => $id) {
            if(!empty($Illustratie1[$teller]['illustratieFile'])){
             echo '<li data-target="#carousel-example-generic" data-slide-to="'.$teller.'"><img src="../pics/'.$Illustratie1[$teller]['illustratieFile'].'" alt="..."></li>';
             $teller++;    
           }  }
           ?>           
         </ol>
        
         <!-- Wrapper for slides -->
         <div class="carousel-inner" role="listbox">
           
           <div class="carousel-item active">
             <div class="img-big-wrap">
               <img src="../pics/<?php echo $advertentie['illustratieFile']; ?>" alt="...">
             </div>           
          </div> 
                 
          <?php 
          $Illustratie2 = HaalIllustratiesOp($advertentie['voorwerpnr']);
          $teller = 1;
          foreach ($Illustratie2 as $rij) {
            if(!empty($Illustratie1[$teller]['illustratieFile'])){
            echo '<div class="carousel-item">
                    <div class="img-big-wrap">
                      <img src="../pics/'.$Illustratie2[$teller]['illustratieFile'].'" alt="...">
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
     <div class="card-body">
         <form class="needs-validation" novalidate action='advertentie.php?id=<?php echo $advertentie['voorwerpnr']?>' method="post">
           <div class="form-row">
        <label for="bod">Bieden: (vanaf: €<?php if(!empty(zijnErBiedingen($advertentie['voorwerpnr'])))
                                                  {$hoogstebod = zijnErBiedingen($advertentie['voorwerpnr']);
                                                    $hoogstebod['euro'] = $hoogstebod['euro'] + 0.01;
                                                    echo $hoogstebod['euro'];}
                                                else{echo $advertentie['startprijs'];} ?> )</label>
         <input type="number" name="bod" class="form-control" id="bod" step="0.01" min="<?php if(!empty(zijnErBiedingen($advertentie['voorwerpnr'])))
                                                   {$hoogstebod = zijnErBiedingen($advertentie['voorwerpnr']);
                                                     $hoogstebod['euro'] = $hoogstebod['euro'] + 0.01;
                                                     echo $hoogstebod['euro'];}
                                                 else{echo $advertentie['startprijs'];} ?>" required>
         <div class="invalid-feedback">
             Voer een bod vanaf €<?php if(!empty(zijnErBiedingen($advertentie['voorwerpnr'])))
                                                       {$hoogstebod = zijnErBiedingen($advertentie['voorwerpnr']);
                                                         $hoogstebod['euro'] = $hoogstebod['euro'] + 0.01;
                                                         echo $hoogstebod['euro'];}
                                                     else{echo $advertentie['startprijs'];} ?>.
         </div>
         <button class="btn btn-lg btn-primary mt-3" type="submit" name="bieden" value="bieden"> Plaats bod </button>
         </form>
       </div>
       </div>
    </div>
    
  <div class="col-md-4">
    <div class="card-body">
   <div class="card">
     <div class="card-header">
       Biedingen
     </div>
     <ul class="list-group list-group-flush">
        <?php if(empty(zijnErBiedingen($advertentie['voorwerpnr']))){
           echo '<li class="list-group-item"> Er zijn nog geen biedingen gedaan</li>';}
           if(!empty(zijnErBiedingen($advertentie['voorwerpnr']))){
                Biedingen($advertentie['voorwerpnr']);}
            
        ?>
     </ul>
   </div>
 </div>
 </div>
 <div class="col-md-5">
   <div class="card-body">
       <a href="#"><?php echo $advertentie['verkoper']; ?></a><br>
       <a href="#">Reviews</a><br><br>
   <button type="button" class="btn btn-primary btn-lg"><a style="color: white;" href="stuurbericht.php?id=<?php echo $advertentie['verkoper']?>">Stuur bericht!</a></button>
   <hr>
   
       <div class="icon-product">
         <img src="assets/img/oog.jpg"></img> <?php echo $advertentie['gezien'] ?> x gezien <br>
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
  </div>
   
</div>

<?php }
else {
  include 'includes/404error.php';
}

include 'includes/footer.php' ?>
