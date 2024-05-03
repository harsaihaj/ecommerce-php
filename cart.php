<?php

session_start();

if (isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['cart'])) {
        $products_array_ids = array_column($_SESSION['cart'], "product_id");
        if (!in_array($_POST['product_id'], $products_array_ids)) {
            $product_id = $_POST['product_id'];
            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_image' => $_POST['product_image'],
                'product_quantity' => $_POST['product_quantity']
            );
            $_SESSION['cart'][$_POST['product_id']] = $product_array;
        } else {
            echo '<script>alert("Product was already added to the cart")</script>';
        }
    } else {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];
        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'product_quantity' => $product_quantity
        );
        $_SESSION['cart'][$product_id] = $product_array;
    }
    calculateTotalCart();
} elseif (isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
    calculateTotalCart();
} elseif (isset($_POST['edit_quantity'])) {
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];
    $product_array = $_SESSION['cart'][$product_id];
    $product_array['product_quantity'] = $product_quantity;
    $_SESSION['cart'][$product_id] = $product_array;
    calculateTotalCart();
}

function calculateTotalCart()
{
    $total_price = 0;
    $total_quantity = 0;
    foreach ($_SESSION['cart'] as $key => $value) {
        $price = $value['product_price'];
        $quantity = $value['product_quantity'];
        $total_price += ($price * $quantity);
        $total_quantity += $quantity;
    }
    $_SESSION['total'] = $total_price;
    $_SESSION['quantity'] = $total_quantity;
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Your Cart</title>
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

    <!-- CART SECTION -->
    <section class="cart container my-5 pt-5">
        <div class="container col-md-12 pt-5">
            <h2 class="font-weight-bold">Your Cart</h2>
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Sub-Total</th>
            </tr>
            <?php foreach ($_SESSION['cart'] as $key => $value) : ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="assets/imgs/<?php echo pathinfo($value['product_image'], PATHINFO_BASENAME); ?>" alt="<?php echo $value['product_name']; ?>">
                            <div>
                                <p><?php echo $value['product_name']; ?></p>
                                <small><span>₹</span><?php echo $value['product_price']; ?></small>
                                <br>
                                <form action="cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                                    <input type="submit" name="remove_product" class="remove-btn" value="Remove">
                                </form>
                            </div>
                        </div>
                    </td>
                    <td>
                        <form action="cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                            <input type="submit" name="edit_quantity" value="Edit" class="edit-btn">
                            <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>">
                        </form>
                    </td>
                    <td>
                        <span>₹</span>
                        <span class="product-price"><?php echo $value['product_quantity'] * $value['product_price']; ?></span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="cart-total">
            <table>
                <tr>
                    <td>Total</td>
                    <td><span>₹</span><?php echo $_SESSION['total']; ?></td>
                </tr>
            </table>
        </div>
        <div class="checkout-container">
            <form action="checkout.php" method="post">
                <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout">
            </form>
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
