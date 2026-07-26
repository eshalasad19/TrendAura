<?php
$page_title = 'Shop Collection';
$page_description = 'Explore curated collections at TrendAura — new arrivals, best sellers, and seasonal picks.';
include('include/header.php') ?>
<?php include('include/navbar.php') ?>

<br>

<?php
include('config/db.php');

// Default values
$category_name = "New Arrival";
$static_description = "Explore our curated selection of premium styles crafted to elevate your wardrobe.";

// Agar URL me category_id mila to DB se naam fetch karo
if (isset($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']);
    $sql = "SELECT category_name FROM category WHERE category_id = $category_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $category_name = $row['category_name'];
    }
}
?>

<!-- page-title -->
<div class="tf-page-title">
    <div class="container-full">
        <div class="heading text-center">
            <?php echo htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <p class="text-center text-2 text_black-2 mt_5">
            <?php echo $static_description; ?>
        </p>
    </div>
</div>
<!-- /page-title -->

<!-- Collection -->
<section class="flat-spacing-3 pb_0">
    <div class="container">
        <div class="hover-sw-nav">
            <?php
            if (isset($category_id)) {
                $sql = "SELECT * FROM sub_category WHERE category_id = '$category_id'";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    ?>
                    <div dir="ltr" class="swiper tf-sw-collection" data-preview="5" data-tablet="3" data-mobile="2"
                        data-space-lg="30" data-space-md="30" data-space="15" data-loop="false" data-auto-play="false">
                        <div class="swiper-wrapper">
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <div class="swiper-slide" lazy="true">
                                    <div class="collection-item style-2 hover-img">
                                        <div class="collection-inner">
                                            <a href="shop-default.php?sub_id=<?php echo $row['sub_id'] ?>" class="collection-image img-style">
                                                <img class="lazyload"
                                                    data-src="<?php echo $row['sub_image']?>"
                                                    src="<?php echo $row['sub_image']?>"
                                                    alt="collection-img">
                                            </a>
                                            <div class="collection-content">
                                                <a href="shop-default.php?sub_id=<?php echo $row['sub_id'] ?>"
                                                    class="tf-btn collection-title hover-icon fs-15"><span><?php echo $row['sub_name']?></span><i
                                                        class="icon icon-arrow1-top-left"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- navigation arrows only if sub categories exist -->
                        <div class="nav-sw nav-next-slider nav-next-collection box-icon w_46 round"><span class="icon icon-arrow-left"></span></div>
                        <div class="nav-sw nav-prev-slider nav-prev-collection box-icon w_46 round"><span class="icon icon-arrow-right"></span></div>
                        <div class="sw-dots style-2 sw-pagination-collection justify-content-center"></div>
                    </div>
                <?php } else { ?>
                    <div class="text-start p-5 w-100">
                        <h4>No Products Found</h4>
                        <a href="home.php" class="tf-btn btn-fill radius-3 mt-3">Go to Home Page</a>
                    </div>
                <?php }
            }
            ?>
        </div>
    </div>
</section>
<!-- /Collection -->

<!-- Section Product -->
<section class="flat-spacing-2">
    <div class="container">
        <div class="wrapper-control-shop">
            <div class="meta-filter-shop"></div>
            <div class="grid-layout wrapper-shop" data-grid="grid-4">
                <?php
                if (isset($category_id)) {
                    $sql = "SELECT * FROM product WHERE cat_id = '$category_id'";
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="card-product" data-price="<?php echo $row['product_price'] ?>">
                                <div class="card-product-wrapper">
                                    <a href="product_details.php?product_id=<?php echo $row['product_id'] ?>" class="product-img">
                                        <img class="lazyload img-product"
                                            data-src="<?php echo $row['product_image'] ?>"
                                            src="<?php echo $row['product_image'] ?>" alt="image-product">
                                        <img class="lazyload img-hover" data-src="<?php echo $row['product_image'] ?>"
                                            src="<?php echo $row['product_image'] ?>" alt="image-product">
                                    </a>
                                </div>
                                <div class="card-product-info">
                                    <a href="product_details.php?product_id=<?php echo $row['product_id'] ?>" class="title link">
                                        <?php echo $row['product_name'] ?>
                                    </a>
                                    <span class="price">Rs. <?php echo number_format($row['product_price']) ?></span>
                                </div>
                            </div>
                        <?php }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>
<!-- /Section Product -->

<?php include('include/footer.php') ?>
