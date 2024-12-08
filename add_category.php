<?php
include 'conn/conn.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_category = trim($_POST['new_category']);

    if (!empty($new_category)) {
        // Insert the new category
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $new_category);
        if ($stmt->execute()) {
            header("Location: create.php"); // Redirect back to the form
        } else {
            die("Error: " . $stmt->error);
        }
    } else {
        echo "Category name cannot be empty.";
    }
}
?>
