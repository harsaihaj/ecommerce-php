<?php
include('server/connection.php');

if(isset($_GET['product_id'])){
  $product_id = $_GET['product_id'];
  $stmt= $conn->prepare("SELECT * FROM products WHERE product_id= ?");
  $stmt->bind_param("i", $product_id);
  $stmt->execute();
  $products = $stmt->get_result();
  $row = $products->fetch_assoc();
} else {
  header('location: index.php');
  exit(); // added exit() to stop further execution
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title></title>
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
  </nav>
    <section class="container single-product my-5 pr-5 " id="margindede">
      <br><br>

      <div class="row mt-5">

        <div class="col-lg-5 col-md-6 col-sm-12">
          <img class="img-fluid w-100 pd-1" src="assets/imgs/<?php echo $row['product_image']; ?>.png" id="mainImg">
          <div class="small-img-group">
            <div class="small-img-col">
              <img src="assets/imgs/<?php echo $row['product_image']; ?>.png" width="100%" class="small-img">
            </div>
            <div class="small-img-col">
              <img src="assets/imgs/<?php echo $row['product_image2']; ?>.png" width="100%" class="small-img">
            </div>
            <div class="small-img-col">
              <img src="assets/imgs/<?php echo $row['product_image3']; ?>.png" width="100%" class="small-img">
            </div>
            <div class="small-img-col">
              <img src="assets/imgs/<?php echo $row['product_image4']; ?>.png" width="100%" class="small-img">
            </div>
          </div>
        </div>

        <div class="col-lg-7 col-md-6 col-sm-12 pt-5">
          <h6><?php echo $row['product_category'] ?></h6>
          <h3 class="py-4"><?php echo $row['product_name'] ?></h3>
          <h2>₹ <?php echo $row['product_price']; ?></h2>

          <form action="cart.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>.png">
            <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
            <input type="number" name="product_quantity" value="1"/>
            <button class="buy-btn" type="submit" name="add_to_cart">Add to Cart</button>
          </form>

          <h4 class="mt-5 mb-5">Product details</h4>
          <span><?php echo $row['product_description']; ?></span>
        </div>
      </div>

    </section>

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
