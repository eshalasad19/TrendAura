<?php
include('auth_check.php');
require_once('../config/csrf.php');
$page_title = 'Track Order';
$page_description = 'Track the status of your TrendAura order.';
include('include/header.php');
include('include/navbar.php');
include('config/db.php');

$user_id = $_SESSION['user']['user_id'];
$order_id = $_GET['order_id'] ?? $_POST['order_id'] ?? '';

if (!ctype_digit((string)$order_id)) {
    die('Invalid order.');
}

// Make sure this order actually belongs to the logged-in user — otherwise
// anyone could view anyone else's order just by guessing an order_id in the URL.
$owner_check = "SELECT DISTINCT o.order_id, o.status, o.orderdate, o.payment_method, o.payment_status, o.address, o.city
                 FROM order_item oi
                 JOIN orderr o ON oi.order_id = o.order_id
                 WHERE oi.order_id = ? AND oi.user_id = ?";
$owner_stmt = mysqli_prepare($conn, $owner_check);
mysqli_stmt_bind_param($owner_stmt, "ii", $order_id, $user_id);
mysqli_stmt_execute($owner_stmt);
$order = mysqli_stmt_get_result($owner_stmt)->fetch_assoc();

if (!$order) {
    echo '<div class="container" style="padding:80px 0;text-align:center;"><h4>Order not found.</h4><a href="my-account.php">Back to My Account</a></div>';
    include('include/footer.php');
    exit;
}

// Customer can cancel their own order, but only while it hasn't shipped yet —
// once it's Shipped/Delivered/already Cancelled, cancelling doesn't make sense.
$cancellable_statuses = ['Pending', 'Processing'];
if (isset($_POST['cancel_order'])) {
    require_csrf();
    if (in_array($order['status'], $cancellable_statuses)) {
        $cancel_stmt = mysqli_prepare($conn, "UPDATE orderr SET status = 'Cancelled' WHERE order_id = ?");
        mysqli_stmt_bind_param($cancel_stmt, "i", $order_id);
        mysqli_stmt_execute($cancel_stmt);

        // Restock every item from this order — the sale didn't go through, so the
        // stock that was deducted when it was ordered needs to come back.
        $items_stmt = mysqli_prepare($conn, "SELECT product_id, quantity FROM order_item WHERE order_id = ?");
        mysqli_stmt_bind_param($items_stmt, "i", $order_id);
        mysqli_stmt_execute($items_stmt);
        $items_result = mysqli_stmt_get_result($items_stmt);
        while ($item = mysqli_fetch_assoc($items_result)) {
            $restock_stmt = mysqli_prepare($conn, "UPDATE product SET stock = stock + ? WHERE product_id = ?");
            mysqli_stmt_bind_param($restock_stmt, "ii", $item['quantity'], $item['product_id']);
            mysqli_stmt_execute($restock_stmt);
        }

        $history_stmt = mysqli_prepare($conn, "INSERT INTO order_status_history (order_id, status, note) VALUES (?, 'Cancelled', 'Cancelled by customer')");
        mysqli_stmt_bind_param($history_stmt, "i", $order_id);
        mysqli_stmt_execute($history_stmt);

        $order['status'] = 'Cancelled'; // reflect immediately without a second query
        echo "<script>showToast('Order cancelled.', 'success');</script>";
    } else {
        echo "<script>showToast('This order can no longer be cancelled.', 'error');</script>";
    }
}

// Pull the status history timeline for this order
$history_stmt = mysqli_prepare($conn, "SELECT status, note, created_at FROM order_status_history WHERE order_id = ? ORDER BY created_at ASC");
mysqli_stmt_bind_param($history_stmt, "i", $order_id);
mysqli_stmt_execute($history_stmt);
$history = mysqli_stmt_get_result($history_stmt);

$all_stages = ['Pending', 'Processing', 'Shipped', 'Delivered'];
$is_cancelled = ($order['status'] === 'Cancelled');
$current_stage_index = array_search($order['status'], $all_stages);
if ($current_stage_index === false) $current_stage_index = 0;
?>

<div class="tf-page-title">
    <div class="container-full">
        <div class="heading text-center">Track Your Order</div>
        <p class="text-center">Order #<?php echo (int) $order['order_id']; ?></p>
    </div>
</div>

<section class="flat-spacing-11">
    <div class="container" style="max-width:760px;">

        <?php if ($is_cancelled): ?>
            <div style="background:#fdf1f1;border:1px solid #f5c2c2;border-radius:8px;padding:18px 22px;margin-bottom:32px;color:#db1215;font-weight:600;">
                This order was cancelled.
            </div>
        <?php else: ?>
        <!-- Stepper -->
        <div style="display:flex;justify-content:space-between;margin-bottom:44px;position:relative;">
            <div style="position:absolute;top:17px;left:0;right:0;height:3px;background:#ebebeb;z-index:0;">
                <div style="height:100%;background:#db1215;width:<?php echo ($current_stage_index / (count($all_stages) - 1)) * 100; ?>%;transition:width .4s;"></div>
            </div>
            <?php foreach ($all_stages as $i => $stage): ?>
                <div style="position:relative;z-index:1;text-align:center;flex:1;">
                    <div style="width:36px;height:36px;border-radius:50%;margin:0 auto 8px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;
                        background:<?php echo $i <= $current_stage_index ? '#db1215' : '#ebebeb'; ?>;
                        color:<?php echo $i <= $current_stage_index ? '#fff' : '#909090'; ?>;">
                        <?php echo $i < $current_stage_index ? '&check;' : $i + 1; ?>
                    </div>
                    <span style="font-size:12px;font-weight:600;color:<?php echo $i <= $current_stage_index ? '#000' : '#909090'; ?>;"><?php echo $stage; ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Order info -->
        <div style="background:#fcfbf9;border-radius:8px;padding:20px 24px;margin-bottom:32px;display:flex;flex-wrap:wrap;gap:24px;">
            <div>
                <div style="font-size:12px;color:#909090;">Order Date</div>
                <div style="font-size:14px;font-weight:600;"><?php echo date('F j, Y', strtotime($order['orderdate'])); ?></div>
            </div>
            <div>
                <div style="font-size:12px;color:#909090;">Payment Method</div>
                <div style="font-size:14px;font-weight:600;"><?php echo htmlspecialchars($order['payment_method'] ?? 'COD', ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
            <div>
                <div style="font-size:12px;color:#909090;">Payment Status</div>
                <div style="font-size:14px;font-weight:600;"><?php echo htmlspecialchars($order['payment_status'] ?? 'Unpaid', ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
            <div>
                <div style="font-size:12px;color:#909090;">Delivering To</div>
                <div style="font-size:14px;font-weight:600;"><?php echo htmlspecialchars($order['city'], ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
        </div>

        <!-- Timeline -->
        <h5 class="fw-5 mb_20">Order History</h5>
        <div style="border-left:2px solid #ebebeb;padding-left:24px;">
            <?php if (mysqli_num_rows($history) > 0): ?>
                <?php while ($h = mysqli_fetch_assoc($history)): ?>
                    <div style="position:relative;padding-bottom:26px;">
                        <div style="position:absolute;left:-30px;top:2px;width:12px;height:12px;border-radius:50%;background:#db1215;border:2px solid #fff;box-shadow:0 0 0 2px #db1215;"></div>
                        <div style="font-size:14px;font-weight:600;"><?php echo htmlspecialchars($h['status'], ENT_QUOTES, 'UTF-8'); ?></div>
                        <?php if (!empty($h['note'])): ?>
                            <div style="font-size:13px;color:#666;margin-top:2px;"><?php echo htmlspecialchars($h['note'], ENT_QUOTES, 'UTF-8'); ?></div>
                        <?php endif; ?>
                        <div style="font-size:12px;color:#909090;margin-top:2px;"><?php echo date('F j, Y — g:i A', strtotime($h['created_at'])); ?></div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color:#909090;font-size:14px;">No history yet.</p>
            <?php endif; ?>
        </div>

        <div style="margin-top:20px;display:flex;gap:12px;flex-wrap:wrap;">
            <a href="my-account.php" class="tf-btn radius-3 btn-outline-dark">&larr; Back to My Account</a>
            <?php if (in_array($order['status'], $cancellable_statuses)): ?>
                <form method="post" id="cancelOrderForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="order_id" value="<?php echo (int) $order['order_id']; ?>">
                    <input type="hidden" name="cancel_order" value="1">
                    <button type="button" id="cancelOrderBtn" class="tf-btn radius-3" style="background:#fdf1f1;color:#db1215;border:1px solid #f5c2c2;">Cancel Order</button>
                </form>
                <script>
                    document.getElementById('cancelOrderBtn').addEventListener('click', function () {
                        showConfirm('Cancel this order? This cannot be undone.', function () {
                            document.getElementById('cancelOrderForm').submit();
                        });
                    });
                </script>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php include('include/footer.php'); ?>