<?php
$page_title = 'Home';
$page_description = 'TrendAura — premium fashion, footwear, and accessories. Discover new arrivals, best sellers, and exclusive collections with fast delivery across Pakistan.';
include('include/header.php') ?>
<?php
// Include database connection
include('config/db.php');

// Start the session
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);
?>

<body class="preload-wrapper">
    <!-- preload -->
    <!-- <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div> -->
    <!-- /preload -->
    <div id="wrapper">
        <header id="header" class="header-default header-absolute header-white bg_light-grey-2">
            <div class="px_15 lg-px_40">
                <div class="row wrapper-header align-items-center">
                    <div class="col-md-4 col-3 tf-lg-hidden">
                        <a href="#mobileMenu" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                            class="btn-mobile">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16"
                                fill="none">
                                <path
                                    d="M2.00056 2.28571H16.8577C17.1608 2.28571 17.4515 2.16531 17.6658 1.95098C17.8802 1.73665 18.0006 1.44596 18.0006 1.14286C18.0006 0.839753 17.8802 0.549063 17.6658 0.334735C17.4515 0.120408 17.1608 0 16.8577 0H2.00056C1.69745 0 1.40676 0.120408 1.19244 0.334735C0.978109 0.549063 0.857702 0.839753 0.857702 1.14286C0.857702 1.44596 0.978109 1.73665 1.19244 1.95098C1.40676 2.16531 1.69745 2.28571 2.00056 2.28571ZM0.857702 8C0.857702 7.6969 0.978109 7.40621 1.19244 7.19188C1.40676 6.97755 1.69745 6.85714 2.00056 6.85714H22.572C22.8751 6.85714 23.1658 6.97755 23.3801 7.19188C23.5944 7.40621 23.7148 7.6969 23.7148 8C23.7148 8.30311 23.5944 8.59379 23.3801 8.80812C23.1658 9.02245 22.8751 9.14286 22.572 9.14286H2.00056C1.69745 9.14286 1.40676 9.02245 1.19244 8.80812C0.978109 8.59379 0.857702 8.30311 0.857702 8ZM0.857702 14.8571C0.857702 14.554 0.978109 14.2633 1.19244 14.049C1.40676 13.8347 1.69745 13.7143 2.00056 13.7143H12.2863C12.5894 13.7143 12.8801 13.8347 13.0944 14.049C13.3087 14.2633 13.4291 14.554 13.4291 14.8571C13.4291 15.1602 13.3087 15.4509 13.0944 15.6653C12.8801 15.8796 12.5894 16 12.2863 16H2.00056C1.69745 16 1.40676 15.8796 1.19244 15.6653C0.978109 15.4509 0.857702 15.1602 0.857702 14.8571Z"
                                    fill="currentColor"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="home.php" class="logo-header">
                            <img src="front-assets/images/logo/logo2.png" alt="logo" class="logo">
                        </a>
                    </div>
                    <div class="col-xl-6 tf-md-hidden">
                        <nav class="box-navigation text-center">
                            <ul class="box-nav-ul d-flex align-items-center justify-content-center gap-30">
                                <li class="menu-item">
                                    <a href="home.php" class="item-link">Home</a>
                                </li>
                                <?php
// Include database connection
include('config/db.php');
?>

                                <li class="menu-item">
                                    <a href="#" class="item-link">Shop<i class="icon icon-arrow-down"></i></a>
                                    <div class="sub-menu mega-menu">
                                        <div class="container">
                                            <div class="row">
                                                <?php
                // Fetch all categories from the database
                $categories_sql = "SELECT category_id, category_name FROM category";
                $categories_result = mysqli_query($conn, $categories_sql);

                if ($categories_result && mysqli_num_rows($categories_result) > 0) {
                    while ($category = mysqli_fetch_assoc($categories_result)) {
                        $category_id = $category['category_id']; // Fetch the ID of the category
                        ?>
                                                <div class="col-lg-3">
                                                    <!-- Adjust column width as needed -->
                                                    <div class="mega-menu-item">
                                                        <!-- Display Category Name -->
                                                        <a href="shop_collection.php?category_id=<?php echo $category['category_id']; ?>"
                                                            class="menu-heading"
                                                            style="font-size: 15px; font-weight: bold;">
                                                            <?php echo $category['category_name']; ?>
                                                        </a>

                                                        <!-- Fetch and Display Subcategories for Each Category -->
                                                        <?php
                                $subcategories_sql = "SELECT * FROM sub_category WHERE category_id = $category_id";
                                $subcategories_result = mysqli_query($conn, $subcategories_sql);

                                if ($subcategories_result && mysqli_num_rows($subcategories_result) > 0) {
                                    echo '<ul class="menu-list">';
                                    while ($subcategory = mysqli_fetch_assoc($subcategories_result)) {
                                        ?>
                                <li>
                                    <a href="shop-default.php?sub_id=<?php echo $subcategory['sub_id']; ?>"
                                        class="menu-link-text link">
                                        <?php echo $subcategory['sub_name']; ?>
                                    </a>
                                </li>
                                <?php
                                    }
                                    echo '</ul>';
                                } else {
                                    echo '<p class="text-muted">No Subcategories</p>';
                                }
                                ?>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo '<p class="text-muted">No Categories Found</p>';
                }
                ?>
            </div>
    </div>
    </div>
    </li>
    <li class="menu-item">
        <a href="about-us.php" class="item-link">About Us</a>
    </li>
    <?php if ($isLoggedIn): ?>
    <li class="menu-item">
        <a href="my-account.php" class="item-link">My Account</a>
    </li>
    <?php else: ?>
    <li class="menu-item">
        <a href="login.php" class="item-link">Login</a>
    </li>
    <?php endif; ?>
    </ul>
    </nav>
    </div>
    <div class="col-xl-3 col-md-4 col-3">
        <ul class="nav-icon d-flex justify-content-end align-items-center gap-20">
            <li class="nav-account">
                <?php if ($isLoggedIn): ?>
                <?php
// session_start();
include('config/db.php');

// Initialize cart count to 0
$cart_count = 0;

// Check if user is logged in
if (isset($_SESSION['user'])) {
    // Get user ID from session
    $user_id = $_SESSION['user']['user_id'];

    // Query to get the count of distinct products in the cart
    $select_cart = "SELECT COUNT(DISTINCT product_id) AS cart_count FROM cart WHERE user_id = ?";
    $select_cart_stmt = mysqli_prepare($conn, $select_cart);
    mysqli_stmt_bind_param($select_cart_stmt, "i", $user_id);
    mysqli_stmt_execute($select_cart_stmt);

    // Execute the query
    $result_cart = mysqli_stmt_get_result($select_cart_stmt);

    // If there are results, get the cart count
    if ($result_cart && mysqli_num_rows($result_cart) > 0) {
        $cart_row = mysqli_fetch_assoc($result_cart);
        $cart_count = $cart_row['cart_count'];  // Get the number of distinct products in the cart
    }
}
?>

            <li class="nav-cart">
                <a href="view-cart.php" class="nav-icon-item">
                    <i class="icon icon-bag"></i>
                    <span class="count-box"><?php echo $cart_count; ?></span>
                </a>
            </li>
            <?php endif; ?>
            </li>
        </ul>
    </div>
    </div>
    </div>
    </header>
    <!-- /Header -->
    <!-- Slider -->
   <section class="tf-slideshow slider-effect-fade slider-home-5 position-relative">
    <div dir="ltr" class="swiper tf-sw-slideshow" data-preview="1" data-tablet="1" data-mobile="1"
        data-centered="false" data-space="0" data-loop="true" data-auto-play="true" data-delay="2000"
        data-speed="1000">
        <div class="swiper-wrapper">
            <?php
            // Database connection
            include('config/db.php');

            $query = "SELECT * FROM slider";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="swiper-slide" lazy="true">
                    <div class="wrap-slider">
                        <img class="lazyload hero-slide-img" data-src="<?php echo $row['image']; ?>"
                            src="<?php echo $row['image']; ?>" alt="slider-image">
                        <div class="box-content text-center">
                            <div class="container">
                                <h1 class="fade-item fade-item-1 text-white heading">
                                    <?php echo $row['title']; ?>
                                </h1>
                                <p class="fade-item fade-item-2 text-white">
                                    <?php echo $row['description']; ?>
                                </p>
                                <!-- <a href="shop-collection-list.html"
                                    class="fade-item fade-item-3 tf-btn btn-light-icon animate-hover-btn btn-xl radius-3">
                                    <span>Shop collection</span>
                                    <i class="icon icon-arrow-right"></i>
                                </a> -->
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="wrap-pagination">
        <div class="sw-dots style-2 dots-white sw-pagination-slider justify-content-center"></div>
    </div>
</section>

    <!-- /Slider -->
    <!-- Collection -->
    <section class="flat-spacing-15">
        <div class="container-full">
            <div class="flat-title flex-row justify-content-between px-0">
                <span class="title wow fadeInUp" data-wow-delay="0s">Featured Collections</span>
                <div class="box-sw-navigation">
                    <div class="nav-sw nav-next-slider nav-next-collection"><span class="icon icon-arrow-left"></span>
                    </div>
                    <div class="nav-sw nav-prev-slider nav-prev-collection"><span class="icon icon-arrow-right"></span>
                    </div>
                </div>
            </div>
            <div dir="ltr" class="swiper tf-sw-collection sw-wrapper-right" data-preview="4.5" data-tablet="2.4"
                data-mobile="2.4" data-space-lg="30" data-space-md="30" data-space="15" data-loop="false"
                data-auto-play="false">
                <div class="swiper-wrapper">
                    <?php include('config/db.php');
                        $sql = 'SELECT * FROM `category`';
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)){
                        ?>
                    <div class="swiper-slide" lazy="true">
                        <div class="collection-item-v3 hover-img">
                            <a href="shop_collection.php?category_id=<?php echo $row['category_id']?>"
                                class="collection-image img-style">
                                <img class="lazyload" data-src="<?php echo $row['category_image'] ?>"
                                    src="<?php echo $row['category_image'] ?>" alt="collection-img">
                                <span class="box-icon">
                                    <i class="icon-icon icon-arrow1-top-left"></i>
                                </span>
                            </a>
                            <div class="collection-content">
                                <a href="shop_collection.php?category_id=<?php echo $row['category_id']?>"
                                    class="link title fw-5"><?php echo $row['category_name'] ?></a>
                                <!-- <div class="count">14 items</div> -->
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- /Collection -->
    <!-- Product -->
 <!-- Product -->
    <?php
// Include the database configuration file
include('config/db.php');

// SQL query to fetch top-selling products
$sql = "SELECT 
            p.product_id,
            p.product_name,
            p.product_image,
            p.product_price,
            p.stock,
            COALESCE(SUM(oi.quantity), 0) AS total_quantity_sold
        FROM 
            product p
        LEFT JOIN 
            order_item oi ON p.product_id = oi.product_id
        GROUP BY 
            p.product_id, p.product_name, p.product_image, p.product_price, p.stock
        ORDER BY 
            total_quantity_sold DESC
        LIMIT 10"; // Limit to top 10 products

$result = mysqli_query($conn, $sql);

// Initialize an empty array for products
$products = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row; // Add each product to the array
    }
} else {
    echo "No products found or query failed.";
}

?>
    <section class="flat-spacing-6 pt_0">
        <div class="container">
            <div class="flat-title wow fadeInUp" data-wow-delay="0s">
                <span class="title">Editor's Picks</span>
                <div class="d-flex gap-16 align-items-center box-pagi-arr">
                    <div class="nav-sw-arrow nav-next-slider nav-next-product">
                        <span class="icon icon-arrow1-left"></span>
                    </div>
                    <a href="product-style-05.html" class="tf-btn btn-line fs-12 fw-6">VIEW ALL</a>
                    <div class="nav-sw-arrow nav-prev-slider nav-prev-product">
                        <span class="icon icon-arrow1-right"></span>
                    </div>
                </div>
            </div>
            <div class="hover-sw-nav hover-sw-2">
                <div dir="ltr" class="swiper tf-sw-product-sell wrap-sw-over" data-preview="4" data-tablet="3"
                    data-mobile="2" data-space-lg="30" data-space-md="15" data-pagination="2" data-pagination-md="3"
                    data-pagination-lg="3">
                    <div class="swiper-wrapper">
                        <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product style-5">
                                <div class="card-product-wrapper">
                                    <a href="product_details.php?product_id=<?= $product['product_id']; ?>"
                                        class="product-img">
                                        <img class="lazyload img-product"
                                            src="<?= htmlspecialchars($product['product_image']); ?>"
                                            alt="<?= htmlspecialchars($product['product_name']); ?>">
                                        <img class="lazyload img-hover"
                                            src="<?= htmlspecialchars($product['product_image']); ?>"
                                            alt="<?= htmlspecialchars($product['product_name']); ?>">
                                    </a>
                                </div>
                                <div class="card-product-info">
                                    <a href="product_details.php?product_id=<?= $product['product_id']; ?>"
                                        class="title link">
                                        <?= htmlspecialchars($product['product_name']); ?>
                                    </a>
                                    <span class="price">Rs.<?= number_format($product['product_price']); ?></span>
                                    <span class="total-sold">Sold: <?= $product['total_quantity_sold']; ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p>No top-selling products available at the moment.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Product -->
    <!-- Icon box -->
    <section class="flat-spacing-9 flat-iconbox-v2">
        <div class="container">
            <div class="wrap-carousel wrap-mobile wow fadeInUp" data-wow-delay="0s">
                <div dir="ltr" class="swiper tf-sw-mobile" data-preview="1" data-space="15">
                    <div class="swiper-wrapper wrap-iconbox">
                        <div class="swiper-slide">
                            <div class="tf-icon-box text-center">
                                <div class="icon">
                                    <i class="icon-shipping-1"></i>
                                </div>
                                <div class="content">
                                    <div class="title">Free Shipping</div>
                                    <p>Free shipping over order $120</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box text-center">
                                <div class="icon">
                                    <i class="icon-payment-1"></i>
                                </div>
                                <div class="content">
                                    <div class="title">Flexible Payment</div>
                                    <p>Pay with Multiple Credit Cards</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box text-center">
                                <div class="icon">
                                    <i class="icon-return-1"></i>
                                </div>
                                <div class="content">
                                    <div class="title">14 Day Returns</div>
                                    <p>Within 30 days for an exchange</p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="sw-dots style-2 sw-pagination-mb justify-content-center"></div>
            </div>
        </div>
    </section>
    <!-- /Icon box -->
   <!-- Shop Gram -->
<section class="flat-spacing-7">
    <div class="container">
        <div class="flat-title wow fadeInUp" data-wow-delay="0s">
            <span class="title">Shop Gram</span>
            <p class="sub-title">Inspire and let yourself be inspired, from one unique fashion to another.</p>
        </div>
        <div class="wrap-carousel wrap-shop-gram">
            <div dir="ltr" class="swiper tf-sw-shop-gallery" data-preview="5" data-tablet="3" data-mobile="2"
                data-space-lg="7" data-space-md="7">
                <div class="swiper-wrapper">
                    <?php
                    // Include the database configuration file
                    include('config/db.php');

                    // Fetch a maximum of 5 categories from the database
                    $sql = "SELECT category_id, category_name, category_image FROM category LIMIT 5";
                    $result = mysqli_query($conn, $sql);

                    // Check if the query returned results
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Display each category as a gallery item
                            ?>
                    <div class="swiper-slide">
                        <div class="gallery-item hover-img wow fadeInUp" data-wow-delay="0s">
                            <div class="img-style">
                                <img class="lazyload img-hover" style="height:250px;"
                                    data-src="<?= htmlspecialchars($row['category_image']); ?>"
                                    src="<?= htmlspecialchars($row['category_image']); ?>"
                                    alt="<?= htmlspecialchars($row['category_name']); ?>">
                            </div>
                            <a href="shop_collection.php?category_id=<?= $row['category_id']; ?>" class="box-icon">
                                <span class="icon icon-bag"></span>
                                <span class="tooltip">View Category</span>
                            </a>
                        </div>
                    </div>
                    <?php
                        }
                    } else {
                        // Display a message if no categories are found
                        echo '<p>No categories available.</p>';
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
            <div class="sw-dots sw-pagination-gallery justify-content-center"></div>
        </div>
    </div>
</section>

<!-- /Shop Gram -->
<?php include('include/footer.php') ?>