<?php
$page_title = 'Shopping Cart';
$page_description = 'Review the items in your TrendAura shopping cart before checkout.';
include('include/header.php') ?>
<?php include('include/navbar.php') ?>
<script>
    window.TOAST_REDIRECT_SUCCESS = 'view-cart.php';
    window.TOAST_REDIRECT_ERROR = 'login.php';
</script>


<!-- page-title -->
<div class="tf-page-title">
    <div class="container-full">
        <div class="heading text-center">Shopping Cart</div>
    </div>
</div>
<!-- /page-title -->

<!-- page-cart -->
<?php

$user = $_SESSION['user'];
$user_id = $user['user_id'];

// Handle the update button click
if (isset($_POST['update'])) {
    $cart_id = $_POST['cart_id'] ?? '';
    $new_quantity = $_POST['number'] ?? 0;

    if (!ctype_digit((string)$cart_id) || !ctype_digit((string)$new_quantity)) {
        echo "<script>showToast('Invalid request.', 'error');</script>";
    } elseif ($new_quantity > 0) {
        // First get product_id and price from cart (scoped to this user — prevents editing someone else's cart)
        $query_cart = "SELECT `product_price`, `product_id` FROM `cart` WHERE `cart_id` = ? AND `user_id` = ?";
        $stmt_cart = mysqli_prepare($conn, $query_cart);
        mysqli_stmt_bind_param($stmt_cart, "ii", $cart_id, $user_id);
        mysqli_stmt_execute($stmt_cart);
        $result_cart = mysqli_stmt_get_result($stmt_cart);
        $row_cart = mysqli_fetch_assoc($result_cart);

        if (!$row_cart) {
            echo "<script>showToast('Cart item not found.', 'error');</script>";
        } else {
            $product_price = $row_cart['product_price'];
            $product_id = $row_cart['product_id'];

            // Now get stock from product table
            $query_stock = "SELECT `stock` FROM `product` WHERE `product_id` = ?";
            $stmt_stock = mysqli_prepare($conn, $query_stock);
            mysqli_stmt_bind_param($stmt_stock, "i", $product_id);
            mysqli_stmt_execute($stmt_stock);
            $row_stock = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_stock));
            $product_stock = $row_stock['stock'];

            // Check if the quantity is available in stock
            if ($new_quantity <= $product_stock) {
                // Calculate the new total price
                $new_total_price = $product_price * $new_quantity;

                // Update the cart with the new quantity and total price
                $update_query = "UPDATE `cart` SET `product_quantity` = ?, `total_price` = ? WHERE `cart_id` = ? AND `user_id` = ?";
                $update_stmt = mysqli_prepare($conn, $update_query);
                mysqli_stmt_bind_param($update_stmt, "idii", $new_quantity, $new_total_price, $cart_id, $user_id);
                $update_result = mysqli_stmt_execute($update_stmt);

                if ($update_result) {
                    // Stock is untouched here — it isn't reserved until checkout.
                    echo "<script>showToast('Cart updated successfully!', 'success');</script>";
                    echo "<script>location.replace('view-cart.php');</script>";
                } else {
                    echo "<script>showToast('Failed to update cart.', 'error');</script>";
                }
            } else {
                echo "<script>showToast('Not enough stock available.', 'error');</script>";
            }
        }
    } else {
        echo "<script>showToast('Quantity must be at least 1.', 'error');</script>";
    }
}

// Handle the remove button click
if (isset($_POST['delete'])) {
    $cart_id = $_POST['cart_id'] ?? '';

    if (!ctype_digit((string)$cart_id)) {
        echo "<script>showToast('Invalid request.', 'error');</script>";
    } else {
        // Ensure the product exists in the cart for the logged-in user
        $check_query = "SELECT * FROM `cart` WHERE `cart_id` = ? AND `user_id` = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "ii", $cart_id, $user_id);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $row = mysqli_fetch_assoc($check_result);
            $product_id = $row['product_id'];
            $product_quantity = $row['product_quantity'];

            // Delete the product from the cart
            $delete_query = "DELETE FROM `cart` WHERE `cart_id` = ? AND `user_id` = ?";
            $delete_stmt = mysqli_prepare($conn, $delete_query);
            mysqli_stmt_bind_param($delete_stmt, "ii", $cart_id, $user_id);
            $delete_result = mysqli_stmt_execute($delete_stmt);

            if ($delete_result) {
                // Stock is untouched here too — it was never deducted when this item
                // was added to the cart, so there's nothing to give back.
                echo "<script>showToast('Product removed from cart successfully!', 'success');</script>";
                echo "<script>location.replace('view-cart.php');</script>";
            } else {
                echo "<script>showToast('Failed to remove product from cart.', 'error');</script>";
            }
        } else {
            echo "<script>showToast('Product not found in cart.', 'error');</script>";
        }
    }
}

?>

<section class="flat-spacing-11">
    <div class="container-full">
        <div class="tf-cart-countdown"></div>
        <div class="tf-page-cart-wrap">
             <?php if ($cart_count > 0) { ?>
            <div class="tf-page-cart-item">
                <table class="tf-table-page-cart">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <?php
                    // Fetch cart items for the logged-in user
                    $query = "SELECT * FROM `cart` WHERE `user_id` = ?";
                    $stmt_items = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt_items, "i", $user_id);
                    mysqli_stmt_execute($stmt_items);
                    $result = mysqli_stmt_get_result($stmt_items);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $cart_id = $row['cart_id']; // Assuming `cart_id` is the primary key in your cart table
                    ?>
                    <tbody>
                        <tr class="tf-cart-item file-delete">
                            <td class="tf-cart-item_product">
                                <p class="img-box">
                                    <img src="<?php echo $row['product_img']; ?>" alt="img-product">
                                </p>
                                <div class="cart-info">
                                    <p class="cart-title link"><?php echo $row['product_name']; ?></p>
                                </div>
                            </td>
                            <td class="tf-cart-item_price" cart-data-title="Price">
                                <div class="cart-price">Rs.<?php echo number_format($row['product_price']); ?></div>
                            </td>
                            <td class="tf-cart-item_quantity" cart-data-title="Quantity">
                                <!-- Form to update quantity -->
                                <form action="" method="POST">
                                    <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
                                    <div class="cart-quantity">
                                        <div class="wg-quantity">
                                            <span class="btn-quantity minus-btn">
                                                <svg class="d-inline-block" width="9" height="1" viewBox="0 0 9 1"
                                                    fill="currentColor">
                                                    <path
                                                        d="M9 1H5.14286H3.85714H0V1.50201e-05H3.85714L5.14286 0L9 1.50201e-05V1Z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <input type="number" name="number"
                                                value="<?php echo $row['product_quantity']; ?>" min="1"
                                                style="width: 50px;">
                                            <span class="btn-quantity plus-btn">
                                                <svg class="d-inline-block" width="9" height="9" viewBox="0 0 9 9"
                                                    fill="currentColor">
                                                    <path
                                                        d="M9 5.14286H5.14286V9H3.85714V5.14286H0V3.85714H3.85714V0H5.14286V3.85714H9V5.14286Z">
                                                    </path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                            </td>
                            <td class="tf-cart-item_total" cart-data-title="Total">
                                <div class="cart-total">Rs.<?php echo number_format($row['total_price']); ?></div>
                            </td>
                            <td class="tf-cart-item_action" style="text-align: right;">
                                <div style="display: inline-flex; flex-direction: column; align-items: center;">
                                    <!-- Update button -->
                                    <form method="POST" action="">
                                        <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
                                        <button type="submit" name="update" class="btn btn-danger">Update</button>
                                    </form>
                                </div>
                            </td>
                            <td class="tf-cart-item_action" style="text-align: left;">
                                <div style="display: inline-flex; flex-direction: column; align-items: center;">
                                    <!-- Remove button -->
                                    <form method="POST" action="">
                                        <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
                                        <button type="submit" name="delete" class="btn btn-danger">Remove</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <?php } ?>
                </table>
            </div>
            <div class="tf-page-cart-footer">
                <div class="tf-cart-footer-inner">
                    <div class="tf-free-shipping-bar">
                        <div class="tf-progress-bar">
                            <span style="width: 50%;">
                                <div class="progress-car">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="14" viewBox="0 0 21 14"
                                        fill="currentColor">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0 0.875C0 0.391751 0.391751 0 0.875 0H13.5625C14.0457 0 14.4375 0.391751 14.4375 0.875V3.0625H17.3125C17.5867 3.0625 17.845 3.19101 18.0104 3.40969L20.8229 7.12844C20.9378 7.2804 21 7.46572 21 7.65625V11.375C21 11.8582 20.6082 12.25 20.125 12.25H17.7881C17.4278 13.2695 16.4554 14 15.3125 14C14.1696 14 13.1972 13.2695 12.8369 12.25H7.72563C7.36527 13.2695 6.39293 14 5.25 14C4.10706 14 3.13473 13.2695 2.77437 12.25H0.875C0.391751 12.25 0 11.8582 0 11.375V0.875ZM2.77437 10.5C3.13473 9.48047 4.10706 8.75 5.25 8.75C6.39293 8.75 7.36527 9.48046 7.72563 10.5H12.6875V1.75H1.75V10.5H2.77437ZM14.4375 8.89937V4.8125H16.8772L19.25 7.94987V10.5H17.7881C17.4278 9.48046 16.4554 8.75 15.3125 8.75C15.0057 8.75 14.7112 8.80264 14.4375 8.89937ZM5.25 10.5C4.76676 10.5 4.375 10.8918 4.375 11.375C4.375 11.8582 4.76676 12.25 5.25 12.25C5.73323 12.25 6.125 11.8582 6.125 11.375C6.125 10.8918 5.73323 10.5 5.25 10.5ZM15.3125 10.5C14.8293 10.5 14.4375 10.8918 14.4375 11.375C14.4375 11.8582 14.8293 12.25 15.3125 12.25C15.7957 12.25 16.1875 11.8582 16.1875 11.375C16.1875 10.8918 15.7957 10.5 15.3125 10.5Z">
                                        </path>
                                    </svg>
                                </div>
                            </span>
                        </div>
                        <div class="tf-progress-msg">
                            Free <span class="price fw-6">Shipping</span> all over the <span
                                class="fw-6">Pakistan</span>
                        </div>
                    </div>
                    <?php
include('config/db.php'); // Database connection

$user = $_SESSION['user'];
$user_id = $user['user_id'];

// Initialize subtotal to 0
$subtotal = 0;

// Fetch all cart items for the user
$query = "SELECT product_price, product_quantity FROM `cart` WHERE `user_id` = ?";
$subtotal_stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($subtotal_stmt, "i", $user_id);
mysqli_stmt_execute($subtotal_stmt);
$result = mysqli_stmt_get_result($subtotal_stmt);

// Calculate subtotal by adding the price * quantity for each product
while ($row = mysqli_fetch_assoc($result)) {
    $subtotal += $row['product_price'] * $row['product_quantity'];
}
?>
                    <div class="tf-page-cart-checkout">
                        <div class="tf-cart-totals-discounts">
                            <h3>Subtotal</h3>
                            <span class="total-value">Rs. <?php echo number_format($subtotal); ?></span>
                        </div>
                        <div class="cart-checkout-btn">
                            <a href="checkout.php"
                                class="tf-btn w-100 btn-fill animate-hover-btn radius-3 justify-content-center">
                                <span>Check out</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
             <?php } else { ?>
               <div class="text-start p-5">
    <h4>Your cart is empty</h4>
    <a href="home.php" class="tf-btn btn-fill radius-3 mt-3">Continue your shopping</a>
</div>
            <?php } ?>
        </div>
    </div>
</section>


<!-- page-cart -->

<div id="toast" class="custom-toast"></div>

<?php include('include/footer.php') ?>