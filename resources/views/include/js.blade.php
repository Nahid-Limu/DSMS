<!-- Bootstrap core JavaScript-->
    
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->

  <script src="js/datatables.min.js"></script>
  <script src="js/canvasjs.js"></script>
  
  <script>
      $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
      });
  </script>

  <script>
      function onCloseModal(fromName) {
      $('#'+fromName).trigger("reset");
      }
  </script>