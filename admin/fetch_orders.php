<?php
include('../config/db.php');

// Get the search query from the POST request
$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';

// Start the SQL query to fetch orders
$sql = "SELECT * FROM orderr 
        INNER JOIN order_item ON orderr.order_id = order_item.order_id
        INNER JOIN product ON order_item.product_id = product.product_id";

$params = [];
$types = '';

// Add the WHERE clause if there is a search term
if ($searchTerm !== '') {
    $sql .= " WHERE orderr.username LIKE ? 
              OR orderr.email LIKE ? 
              OR product.product_name LIKE ? 
              OR orderr.city LIKE ? 
              OR orderr.status LIKE ?";
    $likeTerm = "%$searchTerm%";
    $params = [$likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm];
    $types = 'sssss';
}

$no = 0;
$stmt = mysqli_prepare($conn, $sql);
if ($params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if the query was successful
if ($result) {
    $status_colors = ['Pending' => 'warning', 'Processing' => 'info', 'Shipped' => 'primary', 'Delivered' => 'success', 'Cancelled' => 'danger'];
    // Fetch and display order entries
    while ($row = mysqli_fetch_assoc($result)) {
        $no++;
        $badge = $status_colors[$row['status']] ?? 'secondary';
        echo "<tr>";
        echo "<td>" . $no . "</td>";
        echo "<td>" . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['city'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td><span class='badge bg-{$badge}'>" . htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8') . "</span></td>";
        echo "<td>" . htmlspecialchars($row['payment_method'] ?? 'COD', ENT_QUOTES, 'UTF-8') . " (" . htmlspecialchars($row['payment_status'] ?? 'Unpaid', ENT_QUOTES, 'UTF-8') . ")</td>";
        echo "<td>" . htmlspecialchars($row['orderdate'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . (int) $row['quantity'] . "</td>";
        echo "<td>" . number_format($row['price']) . "</td>";
        echo "<td class='edit'>
                <a href='edit_order.php?order_id=" . (int) $row['order_id'] . "'>
                    <button class='btn edit-item-btn btn-sm btn-success'>Edit</button>
                </a>
              </td>";
        echo "</tr>";
    }
}
?>
