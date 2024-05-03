<?php
include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE product_image LIKE 'shoe%'");
$stmt->execute();
$shoe_products = $stmt->get_result();
?>
