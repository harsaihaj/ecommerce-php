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
    <!--
    <section id="search" class="my-5 py-5 ms-2">
        <div class="container mt-5 py-5">
            <p>Search Products</p>
        </div>

        <form>
            <div class="row mx-auto container">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <p>Category</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="category" id="category_one">
                        <label class="form-check-label" for="category_one">Shoes</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="category" id="category_two" checked>
                        <label class="form-check-label" for="category_two">Coats</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="category" id="category_three">
                        <label class="form-check-label" for="category_three">Watches</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="category" id="category_four">
                        <label class="form-check-label" for="category_four">Bags</label>
                    </div>
                </div>
            </div>

            <div class="row mx-auto container mt-5">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <p>Price</p>
                    <input type="range" class="form-range w-50" min="1" max="1000" id="customRange2">
                    <div class="w-50">
                        <span style="float: left;">1</span>
                        <span style="float:right;">1000</span>
                    </div>
                </div>
            </div>

            <div class="form-group my-3 mx-3">
                <input type="submit" name="search" value="Search" class="btn btn-primary">
            </div>
        </form>
    </section>

-->
    <section id="featured" class="my-5 pb-10 mt-10">
      <div class="container text-center mt-5 py-5">
        <h3>Our Products</h3>
        <hr>
        <p>Here you can check all our Products</p>

        <div class="row mx-auto container-fluid">

          <?php
          include('server/get_all.php');
           ?>


           <?php
           while($row = $featured_products->fetch_assoc()) {
            ?>

            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>.png">
            <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
            <h4 class="p-price">₹ <?php echo $row['product_price']; ?></h4>
            <a href="<?php echo "single_product.php?product_id=".$row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
        </div>


        <?php } ?>

        </div>

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
