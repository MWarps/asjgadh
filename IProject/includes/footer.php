 <?php /*
gevalideerd op 04/06/2019 door Merlijn
validator: https://phpcodechecker.com/
geen problemen gevonden
*/?>
  <hr>
  <div class="footercolor">
    <footer class="footer">
        <div class="container py-2">
          <div class="row">
            <div class="col-md-6">
              <h5>Copyright</h5>
              <small class="d-block mb-3 text-muted">&copy; Project Groep 34 / 2019</small>
            </div>
            <div class="col-md-6">
              <h5>Over ons</h5>
              <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="#">Contact</a></li>
                <li><a class="text-muted" href="#">Algemene voorwaarden</a></li>
                <li><a class="text-muted" href="#">Privacy</a></li>
              </ul>
            </div>
          </div>
        </div>
    </footer>
  </div>
</body>
<script src="assets/js/bootstrap/bootstrap.bundle.js"></script>
<script src="assets/js/script.js"></script>
<script> (function() {
'use strict';
window.addEventListener('load', function() {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function(form) {
form.addEventListener('submit', function(event) {
if (form.checkValidity() === false) {
event.preventDefault();
event.stopPropagation();
}
form.classList.add('was-validated');
}, false);
});
}, false);
})(); </script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
