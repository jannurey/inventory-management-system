<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include 'header.php'; ?>
    
    <div class="container mt-4">
        <h1 class="text-center">Add New Product</h1>
        
        <!-- Product Form -->
        <form action="store.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" name="price" class="form-control" id="price" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" id="quantity" required>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <label for="category" class="form-label me-2">Category</label>
                <select name="category" class="form-select w-50" id="category" required>
                    <option value="">Select Category</option>
                    <?php
                    include 'conn/conn.php';
                    $result = $conn->query("SELECT * FROM categories");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['name']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
                <button type="button" class="btn btn-secondary ms-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add New</button>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="add_category.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="new_category" class="form-label">Category Name</label>
                            <input type="text" name="new_category" class="form-control" id="new_category" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
