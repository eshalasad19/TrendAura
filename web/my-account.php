<?php
include('auth_check.php'); // ✅ Sabse pehle auth check include karo
$page_title = 'My Account';
$page_description = 'View your order history and manage your TrendAura account.';
include('include/header.php');
include('include/navbar.php');
include('config/db.php');

// User ID session se lo
$user_id = $_SESSION['user']['user_id'];

// Fetch orders for the logged-in user
$sql = "SELECT DISTINCT o.order_id, o.username, o.address, o.city, o.email, o.phone, o.orderdate, o.status
        FROM order_item oi
        JOIN orderr o ON oi.order_id = o.order_id
        WHERE oi.user_id = ? ORDER BY o.orderdate DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$order_result = mysqli_stmt_get_result($stmt);

// Check for query errors
if (!$order_result) {
    die('SQL Error: ' . mysqli_error($conn));  // Print SQL error if query fails
}
?>

<!-- page-title -->
<div class="tf-page-title">
    <div class="container-full">
        <div class="heading text-center">My Account</div>
        <p class="text-center">
            Hello, 
            <strong>
                <?php echo htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>
            </strong>
        </p>
    </div>
</div>
<!-- /page-title -->

<!-- page-cart -->
<section class="flat-spacing-11">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="wrap-sidebar-account">
                    <ul class="my-account-nav">
                        <li><a href="my-account.php" class="my-account-nav-item active">Orders</a></li>
                        <li><a href="setting.php" class="my-account-nav-item">Settings</a></li>
                        <li><a href="logout.php" class="my-account-nav-item">Logout</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="my-account-content account-order">
                    <div class="wrap-account-order">
                        <table>
                            <thead>
                                <tr>
                                    <th class="fw-6">Order</th>
                                    <th class="fw-6">Date</th>
                                    <th class="fw-6">Status</th>
                                    <th class="fw-6">Product</th>
                                    <th class="fw-6">Quantity</th>
                                    <th class="fw-6">Tracking</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($order_result) > 0) {
                                    // Loop through each order
                                    while ($order = mysqli_fetch_assoc($order_result)) {
                                        $order_id = $order['order_id'];

                                        // Fetch order items for this order
                                        $order_items_sql = "SELECT oi.*, p.product_name, p.product_price, p.product_image
                                                            FROM order_item oi
                                                            JOIN product p ON oi.product_id = p.product_id
                                                            WHERE oi.order_id = ?";
                                        $order_items_stmt = mysqli_prepare($conn, $order_items_sql);
                                        mysqli_stmt_bind_param($order_items_stmt, "i", $order_id);
                                        mysqli_stmt_execute($order_items_stmt);
                                        $order_items_result = mysqli_stmt_get_result($order_items_stmt);

                                        if (!$order_items_result) {
                                            die('SQL Error: ' . mysqli_error($conn));
                                        }

                                        $status_colors = [
                                            'Pending' => '#b56a00', 'Processing' => '#0d6efd',
                                            'Shipped' => '#6f42c1', 'Delivered' => '#1a9c5b', 'Cancelled' => '#db1215',
                                        ];
                                        $status_color = $status_colors[$order['status']] ?? '#909090';

                                        // Loop through order items
                                        $first_item = true;
                                        while ($item = mysqli_fetch_assoc($order_items_result)) {
                                            echo '<tr class="tf-order-item">';
                                            echo '<td>#' . (int) $order['order_id'] . '</td>';
                                            echo '<td>' . date('F j, Y', strtotime($order['orderdate'])) . '</td>';
                                            echo '<td><span style="color:' . $status_color . ';font-weight:600;font-size:13px;">' . htmlspecialchars($order['status'], ENT_QUOTES, 'UTF-8') . '</span></td>';
                                            echo '<td><img src="' . htmlspecialchars($item['product_image'], ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8') . '" style="width: 50px; height: 50px; object-fit: cover;" /></td>';
                                            echo '<td>' . (int) $item['quantity'] . '</td>';
                                            if ($first_item) {
                                                if (in_array($order['status'], ['Delivered', 'Cancelled'])) {
                                                    echo '<td><span style="font-size:12px;font-weight:700;color:#c0c0c0;cursor:not-allowed;" title="' . ($order['status'] === 'Delivered' ? 'Order delivered' : 'Order cancelled') . '">Track Order</span></td>';
                                                } else {
                                                    echo '<td><a href="track-order.php?order_id=' . (int) $order['order_id'] . '" style="font-size:12px;font-weight:700;color:#db1215;">Track Order &rarr;</a></td>';
                                                }
                                                $first_item = false;
                                            } else {
                                                echo '<td></td>';
                                            }
                                            echo '</tr>';
                                        }
                                    }
                                } else {
                                    echo '<tr><td colspan="6" class="text-center">No data found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- page-cart -->

<div class="btn-sidebar-account">
    <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount" aria-controls="offcanvas"><i class="icon icon-sidebar-2"></i></button>
</div>

<?php include('include/footer.php') ?>