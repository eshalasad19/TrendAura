<?php
$page_title = 'Shop All Products';
$page_description = 'Browse the full TrendAura catalog — clothing, footwear, and accessories for men and women.';
include('include/header.php') ?>
<?php include('include/navbar.php') ?>

<?php
include('config/db.php');

// Default values
$sub_name = "New Arrival";
$static_description = "Discover the best picks tailored just for you.";

// Agar URL me sub_id mila to DB se naam fetch karo
if (isset($_GET['sub_id'])) {
    $sub_id = intval($_GET['sub_id']);
    $sql = "SELECT sub_name FROM sub_category WHERE sub_id = $sub_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $sub_name = $row['sub_name'];
    }
}
?>

<!-- page-title -->
<div class="tf-page-title">
    <div class="container-full">
        <div class="heading text-center">
            <?php echo htmlspecialchars($sub_name, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <p class="text-center text-2 text_black-2 mt_5">
            <?php echo $static_description; ?>
        </p>
    </div>
</div>
<!-- /page-title -->

<!-- Section Product -->
<section class="flat-spacing-2">
    <div class="container">
        <div class="wrapper-control-shop">
            <div class="meta-filter-shop"></div>
            <div class="grid-layout wrapper-shop" data-grid="grid-4">
                <!-- card product -->
                <?php
                if (isset($sub_id)) {
                    $sql = "SELECT * FROM product WHERE sub_cat_id = '$sub_id'";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <div class="card-product" data-price="<?php echo $row['product_price']; ?>">
                            <div class="card-product-wrapper">
                                <a href="product_details.php?product_id=<?php echo $row['product_id']; ?>" class="product-img">
                                    <img class="lazyload img-product"
                                        data-src="<?php echo $row['product_image']; ?>"
                                        src="<?php echo $row['product_image']; ?>" alt="image-product">
                                    <img class="lazyload img-hover"
                                        data-src="<?php echo $row['product_image']; ?>"
                                        src="<?php echo $row['product_image']; ?>" alt="image-product">
                                </a>
                            </div>
                            <div class="card-product-info">
                                <a href="product_details.php?product_id=<?php echo $row['product_id']; ?>" class="title link">
                                    <?php echo $row['product_name']; ?>
                                </a>
                                <span class="price">Rs.<?php echo number_format($row['product_price']); ?></span>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
    </div>
</section>
<!-- /Section Product -->

<?php include('include/footer.php') ?>
