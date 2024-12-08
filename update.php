<?php
include 'conn/conn.php';
$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];

$conn->query("UPDATE products SET name='$name', price=$price, quantity=$quantity WHERE id=$id");
header('Location: index.php');
?>
