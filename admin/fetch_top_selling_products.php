<?php
include('../config/db.php');

// Get the search query from the POST request
$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';

// Start the SQL query to fetch top-selling products.
// Cancelled orders don't count as "sold" — the CASE inside SUM() only
// counts quantity from orders that weren't cancelled.
$sql = "SELECT 
            p.product_id,
            p.product_name,
            p.product_image,
            p.product_price,
            p.stock,
            COALESCE(SUM(CASE WHEN o.status != 'Cancelled' THEN oi.quantity ELSE 0 END), 0) AS total_quantity_sold
        FROM 
            product p
        LEFT JOIN 
            order_item oi ON p.product_id = oi.product_id
        LEFT JOIN
            orderr o ON oi.order_id = o.order_id";

$params = [];
$types = '';

if ($searchTerm !== '') {
    $sql .= " WHERE p.product_name LIKE ?";
    $params[] = "%$searchTerm%";
    $types .= 's';
}

$sql .= " GROUP BY 
            p.product_id, p.product_name, p.product_image, p.product_price, p.stock
          ORDER BY 
            total_quantity_sold DESC
          LIMIT 10";

// Execute the query
$stmt = mysqli_prepare($conn, $sql);
if ($params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$no = 0;
// Check if the query was successful
if ($result) {
    // Loop through the results and generate table rows
    while ($row = mysqli_fetch_assoc($result)) {
        $no++;
        echo "<tr>";
        echo "<td>" . $no . "</td>";
        echo "<td>" . htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td><img src='" . htmlspecialchars($row['product_image'], ENT_QUOTES, 'UTF-8') . "' alt='Product Image' style='width:50px;height:50px;'></td>";
        echo "<td>" . number_format($row['product_price']) . "</td>";
        echo "<td>" . (int) $row['stock'] . "</td>";
        echo "<td>" . (int) $row['total_quantity_sold'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No products found.</td></tr>"; // In case of no matching products
}
?>