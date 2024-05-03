<?php
session_start();
include('server/connection.php'); // Added a semicolon at the end of this line

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        header('location: login.php');
        exit;
    }
}

if (isset($_POST['change_password'])) {
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirm-password']; // Changed 'confirmpassword' to 'confirm-password'
    $user_email = $_SESSION['user_email'];

    if ($password != $confirmpassword) {
        header('location: account.php?error=passwords dont match');
    } elseif (strlen($password) < 6) { // Changed 'else if' to 'elseif'
        header('location: account.php?error=password must be at least 6 characters');
    } else {
        $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email = ?");

        $stmt->bind_param('ss', password_hash($password, PASSWORD_DEFAULT), $user_email); // Added PASSWORD_DEFAULT as the second parameter to password_hash

        if ($stmt->execute()) {
            header('location: account.php?message=password has been updated successfully'); // Changed 'succesfully' to 'successfully'
        } else {
            header('location: account.php?error=could not update password');
        }
    }
}



//get ordersi
if(isset($_SESSION['logged_in'])){
  $user_id = $_SESSION['user_id'];
  $stmt= $conn->prepare("SELECT * FROM orders WHERE user_id=?");
  $stmt->bind_param('i', $user_id);

  $stmt->execute();

  $orders = $stmt->get_result();


}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<!-- NAVBAR -->
<!-- NAVBAR -->
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


<!-- ACCOUNT -->
<section class="my-5 py-5">
    <div class="row container mx-auto">
      <?php
      if(isset($_GET['payment_message'])){
       ?>
       <p class = "mt-5 text-center" style="color:green;"><?php echo $_GET['payment_message']; ?></p>


     <?php } ?>
        <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
            <h3 class="font-weight-bold"> Account Info</h3>
            <hr class="mx-auto">
            <div class="account-info">
                <p>Name <span><?php echo $_SESSION['user_name']; ?></span></p>
                <p>Email - <span><?php echo $_SESSION['user_email']; ?></span></p>
                <p><a href="#orders" id="orders-btn">Your orders</a></p>
                <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12">
            <form id="account-form" method="POST" action="account.php">
                <p class="text-center" style="color:red"> <?php if(isset($_GET['error'])){echo $_GET['error'];} ?></p>
                <p class="text-center" style="color:green"> <?php if(isset($_GET['message'])){echo $_GET['message'];} ?></p>
                <h3>Change Password</h3>
                <hr class="mx-auto">
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="account-password" name="password"
                           placeholder="Password">
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="account-password-confirm" name="confirm-password"
                           placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="submit" value="Change Password" class="btn" id="change-pass-btn"
                           name="change_password">
                </div>
            </form>
        </div>
    </div>
</section>

<section class="orders container my-5 py-3" id="orders">
    <div class="container mt-2">
        <h2 class="font-weight-bold text-center">Your Orders</h2>
        <hr class="mx-auto">
    </div>
    <br>

    <table class="mt-5 pt-5">
        <tr>
            <th>Order id</th>
            <th>Order Cost</th>
            <th>Order Status</th>
            <th>Order Date</th>
            <th>Order Details</th>
        </tr>
        <?php while($row = $orders->fetch_assoc()){ ?>

        <tr>
          <td>
            <div class="product-info">
              <div >
                <p class="mt-3"> <?php echo $row['order_id']; ?></p>

              </div>


            </div>
          </td>
          <td>
            <span><?php echo $row['order_cost'];?></span>
          </td>

          <td>
            <span><?php echo $row['order_status'];?></span>
          </td>

          <td>
            <span><?php echo $row['order_date'];?></span>
          </td>

          <td>
            <form method="POST" action="order_details.php">
              <input type="hidden" name="order_status" value="<?php echo $row['order_status']; ?>">
              <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id">
              <input type="submit" class="btn order-details-btn" value="Details" name="order_details_btn">

            </form>
          </td>


        </tr>

      <?php } ?>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
