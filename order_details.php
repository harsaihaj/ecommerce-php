<?php

include('server/connection.php');

if(isset($_POST['order_details_btn']) && isset($_POST['order_id'])){

  $order_id = $_POST['order_id'];
  $order_status = $_POST['order_status'];

  $stmt=  $conn -> prepare("SELECT * FROM order_items WHERE order_id= ?");

  $stmt->bind_param('i', $order_id);

  $stmt->execute();

  $order_details = $stmt->get_result();
  $order_total_price = calculateTotalOrderPrice($order_details);

}else{

  header('location: account.php');
  exit;
}




function calculateTotalOrderPrice($order_details)
{
    $total = 0;

    foreach($order_details as $row){
      $product_price = $row['product_price'];
      $product_quantity = $row['product_quantity'];

      $total = $total + $product_price * $product_quantity;

    }

    return $total;
}

 ?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>My Website</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

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
  </nav>

<section class="orders container my-5 py-3" id="orders">
    <div class="container mt-5">
        <h2 class="font-weight-bold text-center">Order Details</h2>
        <hr class="mx-auto">
    </div>
    <br>

    <table class="mt-5 pt-5 mx-auto">
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>

        <?php foreach($order_details as $row){ ?>
        <tr>
            <td>
                <div class="product-info">
                  <img src="assets/imgs/<?php echo pathinfo($row['product_image'], PATHINFO_BASENAME); ?>" alt="<?php echo $value['product_name']; ?>" height="100px">
                    <div>
                        <p class="mt-3"> <?php echo $row['product_name']; ?></p>
                    </div>
                </div>
            </td>

            <td>
                <span> <?php echo $row['product_price']; ?></span> <!-- Example price -->
            </td>

            <td>
                <span> <?php echo $row['product_quantity']; ?></span> <!-- Example price -->
            </td>

ss
        </tr>


      <?php } ?>




    </table>





    <?php

    if($order_status == "Not Paid") {?>
      <form style="float:right;" method="POST" action="payment.php">
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
        <input type="hidden" name="order_total_price" value="<?php echo $order_total_price; ?>">
        <input type="hidden" name="order_status" value="<?php echo $order_status; ?>">
        <input type="submit" name="order_pay_btn" class="btn btn-primary" value="Pay Now" style="float:right;">

      </form>
  <?php } ?>

</section>

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
