<?php
include 'includes/header.php';
$beschrijving = haalAdvertentieOp();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col">            
            <nav aria-label="breadcrumb">
              
                <ol class="breadcrumb">
                  <button class="btn btn-sm btn-primary mr-3" id="terug" name="terug" value="terug"><a href="#"></a>Vorige</button>
                  
                    <?php catogorieSoort(); ?>
                    
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
      <h3 class="card-header">Productnaam</h3>
    </div>
  </div>  
  
  <div class="row">
    <div class="col-md-7" >
      <div class="card-body">
        
        <iframe width="100%" height="450px" srcdoc='<html><body><?php echo $beschrijving['beschrijving']; ?></body></html>'></iframe>
    </div>  <!-- item-property-hor .// -->
  </div>
      
 <!-- gallery-wrap .end// -->

   <div class="col-md-5">
     <div class="gallery-wrap card-body" >
       <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
         <!-- Indicators -->
         <ol class="carousel-indicators">
           <li data-target="#carousel-example-generic" data-slide-to="0" class="active"><img  src="assets/img/motor.jpg" alt="..."></li>
           <li data-target="#carousel-example-generic" data-slide-to="1"><img src="assets/img/motor2.jpg" alt="..."></li>
           <li data-target="#carousel-example-generic" data-slide-to="2"><img src="assets/img/motor.jpg" alt="..."></li>
         </ol>
         <!-- The Modal -->
         <div id="myModal" class="modal">
         <!-- The Close Button -->
         <span class="close">&times;</span>
         <!-- Modal Content (The Image) -->
         <img class="modal-content" id="img01">
         </div>
         <!-- slider-product.// -->
         <!-- Wrapper for slides -->
         <div class="carousel-inner" role="listbox">
           <div class="carousel-item active">
             <div class="img-big-wrap">
               <img id="myImg" src="assets/img/motor.jpg" alt="...">
             </div>
                     
          </div>
           <div class="carousel-item">
               <div class="img-big-wrap">
             <img src="assets/img/motor2.jpg" alt="...">
               </div>
             
           </div>
           <div class="carousel-item">
             <div class="img-big-wrap">
             <img src="assets/img/motor.jpg" alt="...">
           </div>
           </div>
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
   
   <div class="form-group col-md-3">
     <div class="card-body">
     
       <p>Bieden: (vanaf: 1000,00)</p>
       
         <form class="needs-validation" novalidate action='register.php' method="post">
         <input type="number" name="bod" class="form-control" id="bod" placeholder="" required>
         <button class="btn btn-lg btn-primary mt-3" id="bieden" type="submit" name="bieden" value="bieden"> Plaats bod </button>
         </form>
       </div>
    </div>
  <div class="col-md-4">
    <div class="card-body">
   <div class="card">
     <div class="card-header">
       Biedingen
     </div>
     <ul class="list-group list-group-flush">
       <li class="list-group-item"><a href="#">€6500,00 Lucas</a></li>
       <li class="list-group-item"><a href="#">€6000,00 Roy</a></li>
       <li class="list-group-item"><a href="#">€5800,00 Merlijn</a></li>
       <li class="list-group-item"><a href="#">€5500,00 Sandra</a></li>
     </ul>
   </div>
 </div>
 </div>
 <div class="col-md-5">
   <div class="card-body">
   <div class="status">
     
       <div class="icon-product">
         <img src="assets/img/oog.jpg"></img>  100 x gezien
         <img src="assets/img/clock.jpg"></img>  sinds 14 mei '19, 14:00  
       </div>
   </div>
       <a href="#">Lucas Schaars</a> <br>
       <a href="#">Reviews (6)</a>
   <button type="button" class="btn btn-primary btn-lg"><a style="color: white;" href="stuurbericht.php">Stuur bericht!</a></button>
</div>
</div>
 
  </div>
  </div>
   
</div>

<!--container.//-->
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
modal.style.display = "block";
modalImg.src = this.src;
captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
modal.style.display = "none";
}
</script>

<?php include 'includes/footer.php' ?>
