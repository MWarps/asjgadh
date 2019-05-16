    <?php
include 'includes/header.php';
    ?>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col mx-3">            
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
      
    <div class="card m-3" style="background-color: #f7f7f6;">
    	<div class="row">
    		<aside class="col-md-5 border-right pr-0">
    <article class="gallery-wrap border-bottom" >
      <div class="img-big-wrap"><img  id="myImg" alt="Motor" src="assets/img/motor.jpg"></div>
      <!-- The Modal -->
<div id="myModal" class="modal">
  <!-- The Close Button -->
  <span class="close">&times;</span>
  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">
</div>
     <!-- slider-product.// -->
    <div class="img-small-wrap">
      <div class="item-gallery"> <img src="assets/img/motor2.jpg"> </div>
      <div class="item-gallery"> <img src="assets/img/motor.jpg"> </div>
      <div class="item-gallery"> <img src="assets/img/motor.jpg"> </div>
      <div class="item-gallery"> <img src="assets/img/motor.jpg"> </div>
    </div> <!-- slider-nav.// -->
    </article> <!-- gallery-wrap .end// -->
    <div class="status p-3 border-bottom">
        <div class="icon-product">
          <img src="assets/img/oog.jpg"></img>100 x gezien
          <img src="assets/img/clock.jpg"></img>sinds 14 mei '19, 14:00  
        </div>
    </div>
    <div class="item-property p-3">
        <a href="#">Lucas Schaars</a> <br>
        <a href="#">Reviews (6)</a>
    </div>  
    <button type="button" class="btn btn-primary btn-lg btn-block">Stuur bericht!</button>
    		</aside>
    		<aside class="col-md-7">
    <article class="card-body p-5">
    	<h3 class="title mb-3">Productnaam</h3>

        <dl class="item-property">
      <dt>Description</dt>
      <dd><p>Here goes description consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    quis nostrud exercitation ullamco </p></dd>
    </dl>
    <dl class="param param-feature">
      <dt>Model#</dt>
      <dd>12345611</dd>
    </dl>  <!-- item-property-hor .// -->
    <dl class="param param-feature">
      <dt>Kleur</dt>
      <dd>Zwart and oranje</dd>
    </dl>  <!-- item-property-hor .// -->
    <dl class="param param-feature">
      <dt>Verzending</dt>
      <dd>Europa</dd>
    </dl>  <!-- item-property-hor .// -->

    <hr>
    	<div class="row">
    		<div class="col-sm-5">
    			<dl class="param param-inline">
    			  <dt>Bieden: </dt>
    			  <dd>
              <form class="needs-validation" novalidate action='register.php' method="post">
              <input type="number" name="bod" class="form-control" id="bod" placeholder="" required>
              <button class="btn btn-lg btn-primary mb-5 mt-3" id="bieden" type="submit" name="bieden" value="bieden"> Biedt! </button>
              </form>
    			  </dd>
    			</dl>  <!-- item-property .// -->
    		</div> <!-- col.// -->
    		<div class="col-sm-7">
    			
    		</div> <!-- col.// -->
    	</div> <!-- row.// -->
    	
    </article> <!-- card-body.// -->
    		</aside> <!-- col.// -->
    	</div> <!-- row.// -->
    </div> <!-- card.// -->


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
