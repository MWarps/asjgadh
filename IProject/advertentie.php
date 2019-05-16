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
      
    </article> <!-- gallery-wrap .end// -->
    <div class="status p-3 border-bottom">
        <div class="icon-product">
          <img src="assets/img/oog.jpg"></img>  100 x gezien
          <img src="assets/img/clock.jpg"></img>  sinds 14 mei '19, 14:00  
        </div>
    </div>
    <div class="item-property p-3">
        <a href="#">Lucas Schaars</a> <br>
        <a href="#">Reviews (6)</a>
    </div>  
    <button type="button" class="btn btn-primary btn-lg btn-block">Stuur bericht!</button>
    		</aside>
    		<aside class="col-md-7">
    <article class="card-body px-5">
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
    		<div class="col-sm-6">
          <div class="form-group col-md-8">
    			<dl class="param param-inline">
    			  <dt>Bieden:</dt> (vanaf: 1000,00)
    			  <dd>
              <form class="needs-validation" novalidate action='register.php' method="post">
              <input type="number" name="bod" class="form-control" id="bod" placeholder="" required>
              <button class="btn btn-lg btn-primary mb-5 mt-3" id="bieden" type="submit" name="bieden" value="bieden"> Plaats bod </button>
              </form>
    			  </dd>
    			</dl> 
        </div> <!-- item-property .// -->
    		</div> <!-- col.// -->
    		<div class="col-sm-6">
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
