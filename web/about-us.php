<?php
$page_title = 'About Us';
$page_description = 'Learn about TrendAura — our story, our mission, and why customers trust us for quality fashion.';
include('include/header.php') ?>
<?php include('include/navbar.php') ?>
        <!-- /Header -->
        <!-- Slider -->
        <section class="tf-slideshow about-us-page position-relative">
            <?php
            include('config/db.php');
            $sql = "SELECT * FROM about_us WHERE about_id = 1";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
             ?>
            <div class="banner-wrapper">
                <img class="lazyload" src="<?php echo $row['about_image'] ?>" data-src="<?php echo $row['about_image'] ?>" alt="image-collection">
                <div class="box-content text-center">
                    <div class="container">
                        <div class="text text-white fw-5"><?php echo $row['about_desc'] ?></div>
                    </div>
                </div>
            </div>
            <?php }?>
        </section>
        <!-- /Slider -->
        <!-- flat-title -->
        <section class="flat-spacing-9">
            <div class="container">
            <?php
            include('config/db.php');
            $sql = "SELECT * FROM about_us WHERE about_id = 2";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
             ?>
                <div class="flat-title my-0">
                    <span class="title"><?php echo $row['about_name'] ?></span>
                    <p class="sub-title text_black-2">
                    <?php echo $row['about_desc'] ?>
                    </p>
                </div>
                <?php }?>
            </div>
        </section>
        <!-- /flat-title -->
        <div class="container"><div class="line"></div></div>
        <!-- image-text -->
        <section class="flat-spacing-23 flat-image-text-section">
        <?php
            include('config/db.php');
            $sql = "SELECT * FROM about_us WHERE about_id = 3";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                ?>
            <div class="container">
                <div class="tf-grid-layout md-col-2 tf-img-with-text style-4">
                    <div class="tf-image-wrap">
                        <img class="lazyload w-100" data-src="<?php echo $row['about_image'] ?>" src="<?php echo $row['about_image'] ?>" alt="collection-img">
                    </div>
                    <div class="tf-content-wrap px-0 d-flex justify-content-center w-100">
                        <div>
                            <div class="heading" style="font-size: 45px;"><?php echo $row['about_name'] ?></div>
                            <div class="text" style="font-size: 16px;" >
                            <?php echo $row['about_desc'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </section>
        <section class="flat-spacing-15">
        <?php
            include('config/db.php');
            $sql = "SELECT * FROM about_us WHERE about_id = 4";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                ?>
            <div class="container">
                <div class="tf-grid-layout md-col-2 tf-img-with-text style-4">
                    <div class="tf-content-wrap px-0 d-flex justify-content-center w-100">
                        <div>
                            <div class="heading" style="font-size: 45px;"><?php echo $row['about_name'] ?></div>
                            <div class="text" style="font-size: 15px;">
                            <?php echo $row['about_desc'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="grid-img-group">
                        <div class="tf-image-wrap box-img item-1">
                            <div class="img-style">
                                <img class="lazyload" src="<?php echo $row['about_image'] ?>" data-src="<?php echo $row['about_image'] ?>" alt="img-slider">
                            </div>
                        </div>
                        <div class="tf-image-wrap box-img item-2">
                            <div class="img-style">
                                <img class="lazyload" src="<?php echo $row['about_image'] ?>" data-src="<?php echo $row['about_image'] ?>" alt="img-slider">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </section>
        <!-- /image-text -->
        <div class="container"><div class="line"></div></div>
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