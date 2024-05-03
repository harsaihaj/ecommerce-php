<?php
session_start();

include 'server/connection.php'; // Ensure to provide the correct path for connection.php

if(isset($_POST['register'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $confirmpassword=$_POST['confirmpassword'];

    if($password != $confirmpassword){
        header('location:register.php?error=passwords dont match');
    } else if(strlen($password) < 6){
        header('location:register.php?error=password must be atleast 6 characters');
    } else {
        // Check whether there is a user with this email
        $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email=?");
        $stmt1->bind_param('s', $email);
        $stmt1->execute();
        $stmt1->bind_result($num_rows);
        $stmt1->store_result();
        $stmt1->fetch();

        if($num_rows != 0){
            header('location:register.php?error=user with this email already exists');
        } else {
            // Create a new user
            $stmt = $conn->prepare("INSERT INTO users (user_name,user_email,user_password) VALUES (?,?,?)");
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password securely

            $stmt->bind_param('sss', $name, $email, $hashed_password);

            if($stmt->execute()){ // Removed the extra semicolon
                $user_id = $stmt->$insert_id;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                $_SESSION['logged_in'] = true; // Changed $true to true
                header('location: account.php?register=You Registered succesfully');
            } else {
                header('location:register.php?error=could not create an account at the moment');
            }
        }
    }
}elseif (isset($_SESSION['logged_in'])) {
header('location: account.php');
exit;
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

        <!--Register-->
        <section class="mt-5 py-5">
            <div class="container text-center mt-3 pt-5">
                <h2 class="form-weight-bold">&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Register</h2>
                <hr class="mx-auto">
            </div>

            <div class="mx-auto container">
                <form action="register.php" id="register-form" method="post">
                  <p style='color:red;'><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
                    <div class="form-group">
                        <label >Name</label>
                        <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required>
                    </div>

                    <div class="form-group">
                        <label >Email</label>
                        <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required>
                    </div>

                    <div class="form-group">
                        <label >Password</label>
                        <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required>
                    </div>

                    <div class="form-group">
                        <label >Confirm Password</label>
                        <input type="password" class="form-control" id="register-confirm-password" name="confirmpassword" placeholder="Confirm Password" required>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn" id="register-btn" value="Register" name="register">
                    </div>

                    <div class="form-group">
                    <a id="login-url" class="btn" href="login.php">Already have an Account? Log in.</a>
                    </div>

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
