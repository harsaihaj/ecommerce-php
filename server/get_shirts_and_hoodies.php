<?php
include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE product_image LIKE 'cloth%' OR product_image LIKE 'hoodie%'");
$stmt->execute();
$hoodie_products = $stmt->get_result();
?>
