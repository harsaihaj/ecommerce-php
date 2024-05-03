<?php

include('connection.php');


$stmt= $conn->prepare("SELECT * FROM products");

$stmt->execute();

$featured_products = $stmt->get_result();



 ?>
