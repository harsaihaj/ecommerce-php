<?php

session_start();
include('connection.php');


if(isset($_GET['transaction_id']) && isset($_GET['order_id'])){



  //change order status to Paid
  $order_id = $_GET['order_id'];
  $order_status = "paid";
  $transaction_id = $_GET['transaction_id'];
  $user_id = $_SESSION['user_id'];
  $payment_date = date('Y-m-d M:i:s');

      $stmt = $conn->prepare("UPDATE orders SET order_status=? WHERE order_id = ?");

      $stmt->bind_param('si', $order_status,$order_id); // Added PASSWORD_DEFAULT as the second parameter to password_hash

      $stmt->execute();
  //store payment Info


  $stmt1 = $conn->prepare("INSERT INTO payments (order_id, user_id, transaction_id,payment_date)
      VALUES(?,?,?,?)");


  $stmt1->bind_param('iiss', $order_id, $user_id, $transaction_id,$payment_date);

  $stmt1->execute();
  //go to user acoount
  header("location:../account.php?payment_message=paid succesfully, thanks for your time");

}else{
  header("location:index.php");
  exit;
}






 ?>
