<?php
session_start();

if(isset($_POST['order_pay_btn'])){
  $order_status= $_POST['order_status'];
  $order_total_price = $_POST['order_total_price'];
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

  <!-- NAVBAR -->
  <?php session_start(); ?>
  <nav class="navbar navbar-expand-lg bg-white py-3 fixed-top">
      <div class="container">
        <a href="index.php">
          <img src="assets/imgs/logo.png" alt=""></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                      <a class="nav-link" href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="shop.php">Shop</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#">Blog</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="contact.html">Contact Us</a>
                  </li>
                  <li class="nav-item">
                      <a href="cart.php"><i class="fas fa-shopping-bag"><?php if(isset($_SESSION['quantity']) && $_SESSION['quantity'] != 0) {?>
                        <span><?php echo $_SESSION['quantity']; ?></span>
                      <?php } ?>
                      </i></a>
                      <a href="account.php"><i class="fas fa-user"></i></a>
                  </li>
              </ul>
          </div>
      </div>
  </nav>    <!-- PAYMENT SECTION -->
    <section class="mt-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold"> &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; Payment</h2>
            <hr class="mx-auto">
        </div>

        <div class="mx-auto container text-center">

        <?php if(isset($_POST['order_status']) && $_POST['order_status'] == "Not Paid") { ?>
          <?php $amount= strval($_POST['order_total_price']); ?>
          <?php $order_id = $_POST['order_id']; ?>
            <p>Total Payment: ₹ <?php echo $_POST['order_total_price'] ?></p>
            <!--<input type="submit" class="btn btn-primary" value="Pay Now">-->
                  <!-- Set up a container element for the button -->
                  <div id="paypal-button-container"></div>


          <?php } else if(isset($_SESSION['total']) && $_SESSION['total'] != 0){?>
            <?php $amount= strval($_SESSION['total']); ?>
            <?php $order_id = $_SESSION['order_id']; ?>

            <p>Total Payment: ₹<?php echo $_SESSION['total']; ?></p>
            <!--<input class="btn-primary" type="submit" value="Pay Now">-->
                  <!-- Set up a container element for the button -->
                  <div class="container text-center">
                    <div id="paypal-button-container"></div>
                  </div>

        <?php } else {?>
          <p>You Dont have An Order</p>
      <?php } ?>

        </div>

    </section>

    <!-- Include the PayPal JavaScript SDK; replace "test" with your own sandbox Business account app client ID -->
    <script src="https://www.paypal.com/sdk/js?client-id=ARX71tQAfmzVHtVVSN_15C5G6nMdmu5wCfB-IE4wOZn9aGCLrmjbT3vLTweKz4Qa240SaY0wOggKL0fe&currency=USD"></script>

    <script>
      paypal.Buttons({
        // Sets up the transaction when a payment button is clicked
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '<?php echo $amount; ?>' // Can reference variables or functions. Example: `value: document.getElementById('...').value`
              }
            }]
          });
        },
        // Finalize the transaction after payer approval
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
            // Successful capture! For dev/demo purposes:
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                var transaction = orderData.purchase_units[0].payments.captures[0];
                alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');
                window.location.href = "server/complete_payment.php?transaction_id="+transaction.id+"&order_id="+<?php echo $order_id; ?>;
            // When ready to go live, remove the alert and show a success message within this page. For example:
            // var element = document.getElementById('paypal-button-container');
            // element.innerHTML = '';
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
            // Or go to another URL:  actions.redirect('thank_you.html');
          });
        }
      }).render('#paypal-button-container');
    </script>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h5 class="text-uppercase">About Us</h5>
                    <p class="text-muted">We are a streetwear brand dedicated to providing high-quality and stylish clothing and accessories for the fashion-forward individual.</p>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h5 class="text-uppercase">Quick Links</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="#" class="text-muted">Home</a></li>
                        <li><a href="#" class="text-muted">Shop</a></li>
                        <li><a href="#" class="text-muted">Blog</a></li>
                        <li><a href="#" class="text-muted">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h5 class="text-uppercase">Follow Us</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="#" class="text-muted"><i class="fab fa-instagram me-2"></i>Instagram</a></li>
                        <li><a href="#" class="text-muted"><i class="fab fa-facebook me-2"></i>Facebook</a></li>
                        <li><a href="#" class="text-muted"><i class="fab fa-twitter me-2"></i>Twitter</a></li>
                        <li><a href="#" class="text-muted"><i class="fab fa-pinterest me-2"></i>Pinterest</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
