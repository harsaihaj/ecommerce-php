<?php
include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE product_image LIKE 'shoe%' LIMIT 4");
$stmt->execute();
$shoe_products = $stmt->get_result();
?>
