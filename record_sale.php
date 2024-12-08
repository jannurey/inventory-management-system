<?php
include 'conn/conn.php';

$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;
if ($product_id) {
    // Fetch the product details from the database
    $product_query = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $product_query->bind_param("i", $product_id);
    $product_query->execute();
    $product = $product_query->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the quantity from the form
    $quantity = $_POST['quantity'];
    $total_amount = $product['price'] * $quantity;

    // Step 1: Insert the sale into the sales table
    $stmt = $conn->prepare("INSERT INTO sales (total_amount) VALUES (?)");
    $stmt->bind_param("d", $total_amount);
    $stmt->execute();
    $sale_id = $stmt->insert_id; // Get the sale ID

    // Step 2: Insert sale details into the sales_details table
    $stmt = $conn->prepare("INSERT INTO sales_details (sale_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $sale_id, $product_id, $quantity, $product['price']);
    $stmt->execute();

    // Step 3: Update the product quantity after the sale
    $new_quantity = $product['quantity'] - $quantity;
    $update_product = $conn->prepare("UPDATE products SET quantity = ? WHERE id = ?");
    $update_product->bind_param("ii", $new_quantity, $product_id);
    $update_product->execute();

    // Redirect to a confirmation page or back to the inventory
    header("Location: index.php?category=" . urlencode($product['category']));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container mt-4">
        <h1 class="text-center">Record Sale</h1>

        <?php if ($product): ?>
            <form action="record_sale.php?product_id=<?= $product['id'] ?>" method="POST">
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" id="quantity" max="<?= $product['quantity'] ?>" min="1" required>
                </div>
                <div class="mb-3">
                    <p>Price per unit: ₱<?= number_format($product['price'], 2) ?></p>
                    <p>Total Amount: ₱<span id="totalAmount"><?= number_format($product['price'], 2) ?></span></p>
                </div>
                <button type="submit" class="btn btn-primary">Record Sale</button>
            </form>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>
    </div>

    <script>
        // Update the total amount dynamically when quantity changes
        document.getElementById('quantity').addEventListener('input', function () {
            var quantity = this.value;
            var price = <?= $product['price'] ?>;
            var totalAmount = quantity * price;
            document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);
        });
    </script>
</body>
</html>
