<style>
    body {
    background-image: url(./assets/img/roads.jpg) ;
    height: 100%;
    background-position: center;
    background-repeat: no-repeat;
    }
</style>

<section id="" class="d-flex align-items-center">
    <div class="container">
        <div style="margin-top: 200px;">
        <h1>Welcome to SLTB</h1>
        </div>
        <div>
            <h3 style="color: red; font-weight: bold;">Online Advanced Highway<br> Bus Reservation </h3>
            <?php if(!isset($_SESSION['login_id'])): ?>
            <button class="btn btn-danger btn-lg" type="button" id="book_now" style="margin-top: 20px;">Reserve Your Tickets Now</button>
            <?php else: ?>
            <center><br><br><br><h2 class="highlight2">Welcome</h2></center>
            <?php endif; ?>
        </div>
    </div>

</section>

  <script>
  	$('#book_now').click(function(){
      uni_modal('Find Schedule','book_filter.php')
  })
  </script>