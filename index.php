<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- External CSS File -->
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Inventory Management System</h1>
        
        <div class="row">
            <!-- Sidebar for Category Filter -->
            <div class="col-md-3">
                <div class="card custom-card">
                    <div class="card-header custom-card-header">
                        <h4>Categories</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php
                            include 'conn/conn.php'; // Database connection

                            // Fetch categories from the database
                            $sql = "SELECT DISTINCT category FROM products";
                            $result = $conn->query($sql);
                            $selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

                            // Loop through categories
                            while ($row = $result->fetch_assoc()):
                                $isSelected = ($row['category'] === $selectedCategory) ? 'selected-category' : '';
                            ?>
                                <li class="list-group-item <?= $isSelected; ?>">
                                    <a href="?category=<?= urlencode($row['category']); ?>" class="text-decoration-none"><?= htmlspecialchars($row['category']); ?></a>
                                </li>
                            <?php endwhile; ?>
                        </ul>

                        <a href="index.php" class="btn btn-secondary mt-3 w-100">Clear Filter</a>
                    </div>
                </div>
            </div>

            <!-- Product Table and Search Bar -->
            <div class="col-md-9">
                <form class="d-flex mb-3" method="GET">
                    <input class="form-control m-2 search-bar" type="text" name="search" placeholder="Search Products" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                    <button class="btn btn-primary m-2 search-btn" type="submit">Search</button>
                </form>

                <a href="create.php" class="btn btn-primary mb-3 add-product-btn">Add New Product</a>
                
                <table class="table table-bordered table-responsive custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'conn/conn.php';

                        $categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
                        $searchFilter = isset($_GET['search']) ? $_GET['search'] : '';

                        $sql = "SELECT * FROM products WHERE 1";
                        if ($categoryFilter) {
                            $sql .= " AND category = '$categoryFilter'";
                        }
                        if ($searchFilter) {
                            $sql .= " AND (name LIKE '%$searchFilter%' OR category LIKE '%$searchFilter%')";
                        }
                        $result = $conn->query($sql);

                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['price'] ?></td>
                                <td><?= $row['quantity'] ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                    <a href="record_sale.php?product_id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Buy</a>
                                </td>
                                <td><?= $row['category'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

</body>
</html>
