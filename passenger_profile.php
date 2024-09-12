<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E-Book Highway</title>
  <link rel="stylesheet" href="path/to/your/css/file.css">
  <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css">
  <script src="path/to/jquery.min.js"></script>
  <script src="path/to/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<?php 
session_start();

if (!isset($_SESSION['login_passenger'])) {
    header('Location: index.php?page=home');
    exit;
}

include 'header.php'; 
include 'db_connect.php';
?>

<?php if(isset($_SESSION['login_passenger'])): ?>
    <?php include 'passenger_navbar.php'; ?>
<!-- <?php else: ?> -->
    <?php include 'navbar.php'; ?>
<!-- <?php endif; ?> -->

<div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-body text-white">
  </div>
</div>

<?php 
if (isset($_GET['page']) && !empty($_GET['page'])) {
    include($_GET['page'] . '.php');
} else {
    include('passenger_home.php');
}
?>

<div class="container mt-5">
    <!-- <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2> -->
    <!-- <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p> -->
</div>

<div class="modal fade" tabindex="-1" id="uni_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success submit" onclick="$('#uni_modal form').submit()">
          <?php echo isset($_SESSION['login_passenger']) ? 'Find' : 'Cancel' ?>
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="confirm_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="confirm" onclick="">Continue</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="book_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>

<div id="preloader"></div>
<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
<script src="assets/js/main.js"></script>

</body>
<script>
  window.uni_modal = function($title = '', $url = '', $book = 0) {
    $('#uni_modal .modal-title').html($title);
    start_load();
    $.ajax({
      url: $url,
      error: err => console.log(err),
      success: function(resp) {
        $('#uni_modal .modal-body').html(resp);
        if ('<?php echo !isset($_SESSION['login_passenger']); ?>' == 1) {
          if ($book == 1) {
            $('#uni_modal .submit').html('Reserve');
          } else {
            $('#uni_modal .submit').html('Find');
          }
        }
        $('#uni_modal .modal-footer').show();
        $('#uni_modal').modal('show');
      },
      complete: function() {
        end_load();
      }
    });
  };

  window._conf = function($msg = '', $func = '', $params = []) {
    $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")");
    $('#confirm_modal .modal-body').html($msg);
    $('#confirm_modal').modal('show');
  };

  window.start_load = function() {
    $('body').prepend('<div id="preloader2"></div>');
  };

  window.end_load = function() {
    $('#preloader2').fadeOut('fast', function() {
      $(this).remove();
    });
  };

  window.alert_toast = function($msg = 'TEST', $bg = 'success') {
    $('#alert_toast').removeClass('bg-success bg-danger bg-info bg-warning');
    if ($bg == 'success') $('#alert_toast').addClass('bg-success');
    if ($bg == 'danger') $('#alert_toast').addClass('bg-danger');
    if ($bg == 'info') $('#alert_toast').addClass('bg-info');
    if ($bg == 'warning') $('#alert_toast').addClass('bg-warning');
    $('#alert_toast .toast-body').html($msg);
    $('#alert_toast').toast({ delay: 3000 }).toast('show');
  };

  $(document).ready(function() {
    // Additional initialization if needed
  });
</script>
</html>
