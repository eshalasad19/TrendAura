<?php
// Fetch product name/description early so the <title> and meta description are
// specific to this product (was previously the same generic "TrendAura" on every product page).
include('config/db.php');
$__seo_product_id = $_GET['product_id'] ?? '';
$page_title = 'Product Not Found';
$page_description = 'Shop premium fashion at TrendAura.';
if (ctype_digit((string)$__seo_product_id)) {
    $__seo_stmt = mysqli_prepare($conn, "SELECT product_name, product_desc FROM product WHERE product_id = ?");
    mysqli_stmt_bind_param($__seo_stmt, "i", $__seo_product_id);
    mysqli_stmt_execute($__seo_stmt);
    $__seo_row = mysqli_stmt_get_result($__seo_stmt)->fetch_assoc();
    if ($__seo_row) {
        $page_title = $__seo_row['product_name'];
        $page_description = mb_strimwidth(trim(strip_tags($__seo_row['product_desc'])), 0, 155, '...');
    }
}
include('include/header.php');
?>
<?php include('include/navbar.php'); ?>

<script>
    window.TOAST_REDIRECT_SUCCESS = 'view-cart.php';
    window.TOAST_REDIRECT_ERROR = 'login.php';
</script>


<!-- breadcrumb -->
<div class="tf-breadcrumb">
    <div class="container">
        <?php
        include('config/db.php');
        $product_id = $_GET['product_id'] ?? '';
        if (!ctype_digit((string)$product_id)) { die('Invalid product.'); }
        $sql = "
        SELECT 
            p.product_id, 
            p.product_name, 
            p.product_image, 
            p.product_price, 
            p.product_desc, 
            p.stock, 
            c.category_id, 
            c.category_name, 
            c.category_image,
            sc.sub_id, 
            sc.sub_name, 
            sc.sub_image
        FROM 
            product p
        INNER JOIN 
            category c 
        ON 
            p.cat_id = c.category_id
        INNER JOIN 
            sub_category sc 
        ON 
            p.sub_cat_id = sc.sub_id
        WHERE 
            p.product_id = ?
        ";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="tf-breadcrumb-wrap d-flex justify-content-between flex-wrap align-items-center">
            <div class="tf-breadcrumb-list">
                <a href="shop_collection.php?category_id=<?php echo $row['category_id'] ?>" class="text"><?php echo $row['category_name']; ?></a>
                <i class="icon icon-arrow-right"></i>
                <a href="#" class="text"><?php echo $row['sub_name']; ?></a>
                <i class="icon icon-arrow-right"></i>
                <span class="text"><?php echo $row['product_name']; ?></span>
            </div>
        </div>
    </div>
</div>

<!-- default -->
<br><br>
<section class="flat-spacing-4 pt_0">
    <div class="tf-main-product section-image-zoom">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="tf-product-media-wrap sticky-top">
                        <div class="thumbs-slider">
                            <div dir="ltr" class="swiper tf-product-media-main" id="gallery-swiper-started">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide" data-color="white">
                                        <a href="<?php echo $row['product_image']; ?>" target="_blank" class="item">
                                            <img class="tf-image-zoom lazyload" data-zoom="<?php echo $row['product_image']; ?>" data-src="<?php echo $row['product_image']; ?>" src="<?php echo $row['product_image']; ?>" alt="img-product">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div dir="ltr" class="swiper tf-product-media-thumbs other-image-zoom" data-direction="vertical">
                                <div class="swiper-wrapper stagger-wrap">
                                    <div class="swiper-slide stagger-item" data-color="white">
                                        <div class="item">
                                            <img class="lazyload" data-src="<?php echo $row['product_image']; ?>" src="<?php echo $row['product_image']; ?>" alt="img-product">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tf-product-info-wrap position-relative">
                        <div class="tf-product-info-list other-image-zoom">
                            <div class="tf-product-info-title">
                                <h6><?php echo $row['product_name']; ?></h6>
                            </div>
                            <div class="tf-product-info-title">
                                <p><?php echo $row['product_desc']; ?></p>
                            </div>
                            <div class="tf-product-info-price">
                                <div class="price-on-sale text_black">Rs.<?php echo number_format($row['product_price']); ?></div>
                            </div>

                            <?php if ($row['stock'] == 0) { ?>
                                <div class="out-of-stock-msg">Out of Stock</div>
                            <?php } else { ?>
                                <form action="" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                    <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                                    <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
                                    <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>">
                                    <div class="tf-product-info-quantity">
                                        <div class="quantity-title fw-6">Quantity</div>
                                        <div class="wg-quantity">
                                            <span class="btn-quantity btn-decrease">-</span>
                                            <input type="number" class="quantity-product" name="number" value="1" min="1">
                                            <span class="btn-quantity btn-increase">+</span>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="tf-product-info-buy-button">
                                        <button class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn-add-to-cart" name="cart" type="submit" style="text-align:center; padding-left: 247px; padding-right: 247px;">
                                            <span>Add to Cart</span>
                                        </button>
                                    </div>
                                    <br>
                                </form>
                            <?php } ?>
                        </div>
                        <div class="tf-product-info-delivery-return">
                                        <div class="row">
                                            <div class="col-xl-6 col-12">
                                                <div class="tf-product-delivery">
                                                    <div class="icon">
                                                        <i class="icon-delivery-time"></i>
                                                    </div>
                                                    <p>Estimate delivery times: <span class="fw-7">12-26 days</span> (International), <span class="fw-7">3-6 days</span> (United States).</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-12">
                                                <div class="tf-product-delivery mb-0">
                                                    <div class="icon">
                                                        <i class="icon-return-order"></i>
                                                    </div>
                                                    <p>Return within <span class="fw-7">30 days</span> of purchase. Duties & taxes are non-refundable.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>

<!-- Cart PHP Logic -->
<?php
$user = $_SESSION['user'] ?? null;
if (isset($_POST['cart'])) {
    if (isset($user['user_id'])) {
        $product_id = $_POST['product_id'] ?? '';
        $quantity = $_POST['number'] ?? 0;

        if (!ctype_digit((string)$product_id) || !ctype_digit((string)$quantity) || (int)$quantity < 1) {
            echo "<script>showToast('Invalid request.', 'error');</script>";
        } else {
            // Trust the database for name/price/image, never the client-submitted values —
            // otherwise a user could tamper with product_price in the browser before submitting.
            $product_query = "SELECT product_name, product_price, product_image, stock FROM product WHERE product_id = ?";
            $product_stmt = mysqli_prepare($conn, $product_query);
            mysqli_stmt_bind_param($product_stmt, "i", $product_id);
            mysqli_stmt_execute($product_stmt);
            $stock_row = mysqli_stmt_get_result($product_stmt)->fetch_assoc();

            if ($stock_row) {
                $product_name = $stock_row['product_name'];
                $product_price = $stock_row['product_price'];
                $product_image = $stock_row['product_image'];
                $available_stock = $stock_row['stock'];

                if ($quantity > $available_stock) {
                    echo "<script>showToast('Requested quantity exceeds stock! Only $available_stock left.', 'error');</script>";
                } else {
                    $total_price = $product_price * $quantity;
                    $user_id = $user['user_id'];

                    $cart_sql = "INSERT INTO `cart` (`product_name`, `product_price`, `product_img`, `product_quantity`, `total_price`, `user_id`, `product_id`) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $cart_stmt = mysqli_prepare($conn, $cart_sql);
                    mysqli_stmt_bind_param($cart_stmt, "sdsdiii", $product_name, $product_price, $product_image, $quantity, $total_price, $user_id, $product_id);

                    if (mysqli_stmt_execute($cart_stmt)) {
                        // Stock is NOT deducted here anymore — a cart item is just a
                        // reservation intent, not a committed sale. Stock only decreases
                        // when the order is actually placed at checkout.
                        echo "<script>showToast('Product added to cart successfully!', 'success');</script>";
                    } else {
                        echo "<script>showToast('Failed to add product to cart!', 'error');</script>";
                    }
                }
            } else {
                echo "<script>showToast('Product not found!', 'error');</script>";
            }
        }
    } else {
        echo "<script>showToast('Please log in to add items to the cart!', 'error');</script>";
    }
}
?>

<?php include('include/footer.php'); ?>