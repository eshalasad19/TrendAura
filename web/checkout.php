<?php
include('config/db.php');
require_once('../config/csrf.php');
include('auth_check.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'PHPMailer/phpmailer/PHPMailer.php';
require 'PHPMailer/phpmailer/SMTP.php';
require 'PHPMailer/phpmailer/Exception.php';

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$page_title = 'Checkout';
$page_description = 'Complete your purchase securely at TrendAura.';
include('include/header.php');
include('include/navbar.php');

// Page Title
echo '<div class="tf-page-title"><div class="container-full"><div class="heading text-center">Check Out</div></div></div>';
?>
<script>
    window.TOAST_REDIRECT_SUCCESS = 'view-cart.php';
    window.TOAST_REDIRECT_ERROR = 'login.php';
</script>


<section class="flat-spacing-11">
    <div class="container">
        <div class="tf-page-cart-wrap layout-2">
            <div class="tf-page-cart-item">
                <h5 class="fw-5 mb_20">Billing details</h5>
                <form class="form-checkout" action="" method="post">
                    <?php echo csrf_field(); ?>
                    <fieldset class="fieldset">
                        <label for="first-name">Name</label>
                        <input type="text" id="first-name" name="name" value="<?php echo $_SESSION['user']['username']; ?>" placeholder="Your Name">
                    </fieldset>
                    <br>
                    <fieldset class="box fieldset">
                        <label for="city">Town/City</label>
                        <input type="text" id="city" name="city" placeholder="City">
                    </fieldset>
                    <fieldset class="box fieldset">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" placeholder="Address">
                    </fieldset>
                    <fieldset class="box fieldset">
                        <label for="phone">Phone Number</label>
                        <input type="number" id="phone" name="phone" placeholder="Phone">
                    </fieldset>
                    <fieldset class="box fieldset">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $_SESSION['user']['email']; ?>" placeholder="Your Email">
                    </fieldset>

                    <!-- Payment method: Cash on Delivery only for now.
                         See PAYMENT_GATEWAY_README.md for how to add a real gateway later. -->
                    <input type="hidden" name="payment_method" value="COD">
                    <fieldset class="box fieldset" style="margin-bottom:20px;">
                        <label style="display:block;margin-bottom:6px;font-weight:600;">Payment Method</label>
                        <p style="font-size:14px;color:#333;margin:0;">Cash on Delivery</p>
                    </fieldset>

                    <button class="tf-btn radius-3 btn-fill btn-icon animate-hover-btn justify-content-center" type="submit" name="placeorder" id="placeOrderBtn">Place order</button>
                </form>
            </div>
            <div class="tf-page-cart-footer">
                <div class="tf-cart-footer-inner">
                    <h5 class="fw-5 mb_20">Your order</h5>
                    <?php
                    $user = $_SESSION['user'];
                    $user_id = $user['user_id'];
                    $select = "SELECT * FROM cart WHERE user_id = ?";
                    $select_stmt = mysqli_prepare($conn, $select);
                    mysqli_stmt_bind_param($select_stmt, "i", $user_id);
                    mysqli_stmt_execute($select_stmt);
                    $result = mysqli_stmt_get_result($select_stmt);
                    while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <form class="tf-page-cart-checkout widget-wrap-checkout" action="" method="post">
                        <ul class="wrap-checkout-product">
                            <li class="checkout-product-item">
                                <figure class="img-product">
                                    <img src="<?php echo $row['product_img'] ?>" alt="product">
                                    <span class="quantity"><?php echo $row['product_quantity'] ?></span>
                                </figure>
                                <div class="content">
                                    <div class="info">
                                        <p class="name"><?php echo $row['product_name'] ?></p>
                                    </div>
                                    <span class="price">Rs.<?php echo number_format($row['total_price']) ?></span>
                                </div>
                            </li>
                        </ul>
                    </form>
                    <?php } ?>
                    <br><br>
                    <?php
                    $subtotal = 0;
                    $cart_query = "SELECT product_price, product_quantity FROM `cart` WHERE `user_id` = ?";
                    $cart_stmt = mysqli_prepare($conn, $cart_query);
                    mysqli_stmt_bind_param($cart_stmt, "i", $user_id);
                    mysqli_stmt_execute($cart_stmt);
                    $result = mysqli_stmt_get_result($cart_stmt);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $subtotal += $row['product_price'] * $row['product_quantity'];
                    }
                    ?>
                    <div class="d-flex justify-content-between line pb_20">
                        <h6 class="fw-5">Total</h6>
                        <h6 class="total fw-5">Rs.<?php echo number_format($subtotal) ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$user = $_SESSION['user'];

if (isset($_POST['placeorder'])) {
    require_csrf();
    $user_id = $user['user_id'];
    $name = trim($_POST['name']);
    $city = trim($_POST['city']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    // Payment method — dummy gateway for now (Card/JazzCash/Easypaisa are simulated as
    // instantly "Paid" in test mode; only COD stays genuinely unpaid until delivery).
    $allowed_payment_methods = ['COD', 'Card', 'JazzCash', 'Easypaisa'];
    $payment_method = in_array($_POST['payment_method'] ?? '', $allowed_payment_methods) ? $_POST['payment_method'] : 'COD';
    $payment_status = ($payment_method === 'COD') ? 'Unpaid' : 'Paid';

    // Insert order
    $insert_order_query = "INSERT INTO `orderr` (`username`, `address`, `city`, `email`, `phone`, `orderdate`, `status`, `payment_method`, `payment_status`) 
                           VALUES (?, ?, ?, ?, ?, NOW(), 'Pending', ?, ?)";
    $insert_order_stmt = mysqli_prepare($conn, $insert_order_query);
    mysqli_stmt_bind_param($insert_order_stmt, "sssssss", $name, $address, $city, $email, $phone, $payment_method, $payment_status);

    if (mysqli_stmt_execute($insert_order_stmt)) {
        $order_id = mysqli_insert_id($conn); // Get the last inserted order ID

        // Seed the tracking timeline with the first entry
        $history_stmt = mysqli_prepare($conn, "INSERT INTO order_status_history (order_id, status, note) VALUES (?, 'Pending', ?)");
        $history_note = 'Order placed — payment method: ' . $payment_method;
        mysqli_stmt_bind_param($history_stmt, "is", $order_id, $history_note);
        mysqli_stmt_execute($history_stmt);

        // Fetch cart items
        $cart_query = "SELECT * FROM cart WHERE user_id = ?";
        $cart_result_stmt = mysqli_prepare($conn, $cart_query);
        mysqli_stmt_bind_param($cart_result_stmt, "i", $user_id);
        mysqli_stmt_execute($cart_result_stmt);
        $cart_result = mysqli_stmt_get_result($cart_result_stmt);

        if ($cart_result && mysqli_num_rows($cart_result) > 0) {
            $unavailable_items = [];
            while ($cart_item = mysqli_fetch_assoc($cart_result)) {
                $product_id = $cart_item['product_id'];
                $price = $cart_item['total_price'];
                $quantity = $cart_item['product_quantity'];

                // Stock is checked and deducted here — at the moment the order is
                // actually placed — not earlier when the item was just added to cart.
                $stock_check_stmt = mysqli_prepare($conn, "SELECT stock, product_name FROM product WHERE product_id = ? FOR UPDATE");
                mysqli_stmt_bind_param($stock_check_stmt, "i", $product_id);
                mysqli_stmt_execute($stock_check_stmt);
                $stock_row = mysqli_stmt_get_result($stock_check_stmt)->fetch_assoc();

                if (!$stock_row || $stock_row['stock'] < $quantity) {
                    $unavailable_items[] = $stock_row['product_name'] ?? ('Product #' . $product_id);
                    continue; // skip this item — not enough stock to fulfill it
                }

                // Insert each cart item into the order_item table
                $insert_order_item_query = "INSERT INTO `order_item` (`order_id`, `product_id`, `quantity`, `price`, `user_id`) 
                                            VALUES (?, ?, ?, ?, ?)";
                $item_stmt = mysqli_prepare($conn, $insert_order_item_query);
                mysqli_stmt_bind_param($item_stmt, "iiidi", $order_id, $product_id, $quantity, $price, $user_id);
                mysqli_stmt_execute($item_stmt);

                $deduct_stmt = mysqli_prepare($conn, "UPDATE product SET stock = stock - ? WHERE product_id = ?");
                mysqli_stmt_bind_param($deduct_stmt, "ii", $quantity, $product_id);
                mysqli_stmt_execute($deduct_stmt);
            }

            if (!empty($unavailable_items)) {
                $names = htmlspecialchars(implode(', ', $unavailable_items), ENT_QUOTES, 'UTF-8');
                echo "<script>showToast('Some items were out of stock and were not included: {$names}', 'error');</script>";
            }

            // ✅ Clear the user's cart
            $del_cart_stmt = mysqli_prepare($conn, "DELETE FROM `cart` WHERE `user_id` = ?");
            mysqli_stmt_bind_param($del_cart_stmt, "i", $user_id);
            mysqli_stmt_execute($del_cart_stmt);

            // ✅ Prepare order details for email
            $order_items_html = "";
            $order_items_query = "SELECT oi.quantity, oi.price, p.product_name 
                                  FROM order_item oi 
                                  JOIN product p ON oi.product_id = p.product_id
                                  WHERE oi.order_id = ?";
            $order_items_stmt = mysqli_prepare($conn, $order_items_query);
            mysqli_stmt_bind_param($order_items_stmt, "i", $order_id);
            mysqli_stmt_execute($order_items_stmt);
            $order_items_result = mysqli_stmt_get_result($order_items_stmt);

            if ($order_items_result && mysqli_num_rows($order_items_result) > 0) {
                while ($item = mysqli_fetch_assoc($order_items_result)) {
                    $order_items_html .= "
                        <tr>
                            <td style='padding:10px; border-bottom:1px solid #ebebeb; font-size:13px; color:#333;'>{$item['product_name']}</td>
                            <td align='center' style='padding:10px; border-bottom:1px solid #ebebeb; font-size:13px; color:#333;'>{$item['quantity']}</td>
                            <td align='right' style='padding:10px; border-bottom:1px solid #ebebeb; font-size:13px; color:#333;'>Rs. {$item['price']}</td>
                        </tr>";
                }
            }

            // ✅ Send Email
            try {
                $mail->isSMTP();
                $mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
                $mail->SMTPAuth = true;
                $mail->Username = env('MAIL_USERNAME');
                $mail->Password = env('MAIL_PASSWORD');
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = (int) env('MAIL_PORT', 465);

                $mail->setFrom(env('MAIL_USERNAME'), 'TrendAura');
                $mail->addAddress($email, $name);

                $mail->isHTML(true);
                $mail->Subject = "Thank you for your order - TrendAura";

                $mail->Body = "
                <div style='font-family: Arial, Helvetica, sans-serif; background:#f6f6f6; padding:30px 0; margin:0;'>
                <table role='presentation' width='100%' cellpadding='0' cellspacing='0' style='max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden;'>

                    <tr>
                        <td style='background:#000000; padding:28px 32px;'>
                            <span style='color:#ffffff; font-size:22px; font-weight:700; letter-spacing:1px;'>TREND<span style='color:#db1215;'>AURA</span></span>
                        </td>
                    </tr>

                    <tr>
                        <td style='padding:32px;'>
                            <h2 style='margin:0 0 6px; font-size:20px; color:#000;'>Thanks for your order, $name!</h2>
                            <p style='margin:0 0 22px; font-size:14px; color:#666;'>We've received your order and we're getting it ready.</p>

                            <table role='presentation' width='100%' cellpadding='0' cellspacing='0' style='background:#fcfbf9; border-radius:6px; padding:16px; margin-bottom:22px;'>
                                <tr>
                                    <td style='padding:6px 16px; font-size:13px; color:#909090;'>Order ID</td>
                                    <td style='padding:6px 16px; font-size:13px; color:#000; font-weight:600; text-align:right;'>#$order_id</td>
                                </tr>
                                <tr>
                                    <td style='padding:6px 16px; font-size:13px; color:#909090;'>Payment Method</td>
                                    <td style='padding:6px 16px; font-size:13px; color:#000; font-weight:600; text-align:right;'>$payment_method</td>
                                </tr>
                                <tr>
                                    <td style='padding:6px 16px; font-size:13px; color:#909090;'>Payment Status</td>
                                    <td style='padding:6px 16px; font-size:13px; text-align:right;'>
                                        <span style='background:" . ($payment_status === 'Paid' ? '#e7f7ee;color:#1a9c5b' : '#fff4e5;color:#b56a00') . "; padding:3px 10px; border-radius:100px; font-weight:600; font-size:11px;'>$payment_status</span>
                                    </td>
                                </tr>
                            </table>

                            <h3 style='font-size:14px; color:#000; margin:0 0 10px; text-transform:uppercase; letter-spacing:.5px;'>Order Summary</h3>
                            <table role='presentation' width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse; margin-bottom:20px;'>
                                <thead>
                                    <tr>
                                        <th align='left' style='padding:10px; border-bottom:2px solid #000; font-size:12px; color:#000;'>Product</th>
                                        <th align='center' style='padding:10px; border-bottom:2px solid #000; font-size:12px; color:#000;'>Qty</th>
                                        <th align='right' style='padding:10px; border-bottom:2px solid #000; font-size:12px; color:#000;'>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    $order_items_html
                                </tbody>
                            </table>

                            <table role='presentation' width='100%' cellpadding='0' cellspacing='0'>
                                <tr>
                                    <td style='padding:12px 0; border-top:2px solid #000; font-size:15px; font-weight:700; color:#000;'>Total</td>
                                    <td style='padding:12px 0; border-top:2px solid #000; font-size:15px; font-weight:700; color:#db1215; text-align:right;'>Rs. $subtotal</td>
                                </tr>
                            </table>

                            <h3 style='font-size:14px; color:#000; margin:24px 0 10px; text-transform:uppercase; letter-spacing:.5px;'>Delivery Details</h3>
                            <p style='font-size:14px; color:#333; margin:0 0 4px;'>$address, $city</p>
                            <p style='font-size:14px; color:#333; margin:0 0 4px;'>Phone: $phone</p>
                            <p style='font-size:13px; color:#909090; margin:6px 0 0;'>Estimated delivery: 3–5 working days</p>

                            <div style='text-align:center; margin-top:30px;'>
                                <a href='#' style='display:inline-block; background:#db1215; color:#ffffff; text-decoration:none; font-size:13px; font-weight:700; padding:13px 32px; border-radius:4px;'>Track Your Order</a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style='background:#000000; padding:20px 32px; text-align:center;'>
                            <p style='margin:0; font-size:12px; color:rgba(255,255,255,.6);'>TrendAura &copy; " . date('Y') . " — Thanks for shopping with us.</p>
                        </td>
                    </tr>

                </table>
                </div>
                ";

                $mail->AltBody = "Hi $name, Your order #$order_id has been placed successfully. 
                Total: Rs.$subtotal. Delivery in 3-5 working days.";

                $mail->send();
            } catch (Exception $e) {
                error_log("Email failed: " . $mail->ErrorInfo);
            }

echo "<script>showToast('Order placed successfully!', 'success');</script>";

        } else {
            echo "No items in cart.";
        }
    } else {
        echo "Error placing order: " . mysqli_error($conn);
    }
}
?>

<?php include('include/footer.php'); ?>