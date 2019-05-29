<?php 
$_SESSION['gebruikersnaam'] == '';
echo $DP;
include 'includes/header.php';
echo 'hieronder moet de array van session weegeven worden:';
print_r($_SESSION);
?>
<div class="container">
  <div class="row">
      <div class="offset-3 col-md-6 mt-4">
        <div class="jumbotron bg-dark text-white">
          <h3 class="h3 mb-4 text-center "> OOPS! Sorry... </h3>
            <p>Status Code: 007
              <br>
              <br>
               Je bent geblokeerd neem contact met ons op via het contact formulier. 
            </p>
        </div>
      </div>
  </div>
</div>
<?php 
include 'includes/footer.php'
?>