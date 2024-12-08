<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include 'header.php'; ?> <!-- Include header.php for navigation -->

    <div class="container mt-4">
        <h1 class="text-center mb-4">Sales Records</h1>

        <!-- Table to Display Sales Details -->
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th style="background: black; color: white;">Sale ID</th>
                    <th style="background: black; color: white;">Product Name</th>
                    <th style="background: black; color: white;">Quantity Sold</th>
                    <th style="background: black; color: white;">Sale Price</th>
                    <th style="background: black; color: white;">Total Sale Amount</th>
                    <th style="background: black; color: white;">Sale Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection
                include 'conn/conn.php';

                // SQL query to fetch sales records, product details, and sale date
                $sql = "
                    SELECT sales.id AS sale_id, products.name AS product_name, 
                           sales_details.quantity, sales_details.price, 
                           (sales_details.quantity * sales_details.price) AS total_amount,
                           sales.sale_date
                    FROM sales
                    JOIN sales_details ON sales.id = sales_details.sale_id
                    JOIN products ON sales_details.product_id = products.id
                    ORDER BY sales.sale_date DESC
                ";

                // Execute the query
                $result = $conn->query($sql);

                // Check if there are records
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= $row['sale_id'] ?></td>
                            <td><?= $row['product_name'] ?></td>
                            <td><?= $row['quantity'] ?></td>
                            <td><?= number_format($row['price'], 2) ?></td>
                            <td><?= number_format($row['total_amount'], 2) ?></td>
                            <td><?= $row['sale_date'] ?></td>
                        </tr>
                        <?php
                    endwhile;
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No sales records found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
