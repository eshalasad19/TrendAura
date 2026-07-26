<?php
include('../config/db.php');

$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';

$query = "
    SELECT 
        r.id AS user_id,
        r.name,
        r.email,
        SUM(oi.quantity * oi.price) AS total_sales,
        COUNT(DISTINCT oi.order_id) AS total_orders
    FROM register r
    JOIN role ro ON r.role_id = ro.role_id
    JOIN order_item oi ON r.id = oi.user_id
    JOIN orderr o ON oi.order_id = o.order_id
    WHERE ro.role_name = 'User' AND o.status != 'Cancelled'
";

$params = [];
$types = '';

if ($searchTerm !== '') {
    $query .= " AND (r.name LIKE ? OR r.email LIKE ?)";
    $likeTerm = "%$searchTerm%";
    $params = [$likeTerm, $likeTerm];
    $types = 'ss';
}

$query .= "
    GROUP BY r.id, r.name, r.email
    ORDER BY total_sales DESC
    LIMIT 10
";

$stmt = mysqli_prepare($conn, $query);
if ($params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>Rs " . number_format($row['total_sales']) . "</td>";
        echo "<td>" . (int) $row['total_orders'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No top sellers found.</td></tr>";
}
?>