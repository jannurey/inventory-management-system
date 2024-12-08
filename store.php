<?php
include 'conn/conn.php';

// Retrieve and sanitize input
$name = $conn->real_escape_string($_POST['name']);
$price = $conn->real_escape_string($_POST['price']);
$quantity = $conn->real_escape_string($_POST['quantity']);
$category = $conn->real_escape_string($_POST['category']);

// Corrected SQL query to include the `category` field
$sql = "INSERT INTO products (name, price, quantity, category) VALUES ('$name', $price, $quantity, '$category')";

if ($conn->query($sql)) {
    // Redirect to the main page if the query is successful
    header('Location: index.php');
} else {
    // Display the error if the query fails
    die("Error: " . $conn->error);
}
?>
