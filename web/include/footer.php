<?php
// Include database connection
include('config/db.php');

// Start the session
// session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);
?>
       <!-- Footer -->
        <footer id="footer" class="footer md-pb-70">
            <div class="footer-wrap">
                <div class="footer-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="footer-infor">
                                    <div class="footer-logo">
                                            <img src="front-assets/images/logo/logo1.png" alt="">
                                    </div>
                                    <?php
                                    include('config/db.php');
                                    $sql = "SELECT * FROM contact_details LIMIT 3";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_assoc($result)){
                                    ?>
                                    <ul>
                                        <li>
                                            <p><?php echo $row['heading'] ?> <?php echo $row['description']?></p>
                                        </li>
                                    </ul>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12 footer-col-block">
                                <div class="footer-heading footer-heading-desktop">
                                    <h6>Top Categories</h6>
                                </div>
                                <div class="footer-heading footer-heading-moblie">
                                    <h6>Top Categories</h6>
                                </div>
                                <ul class="footer-menu-list tf-collapse-content">
                                    <?php
                                    include('config/db.php');
                                    $sql = "SELECT * FROM category";
                                    $result = mysqli_query($conn, $sql);
                                    while($row = mysqli_fetch_assoc($result)){
                                    ?>
                                    <li>
                                        <a href="shop_collection.php?category_id=<?php echo $row['category_id'] ?>"
                                            class="footer-menu_item"><?php echo $row['category_name'] ?></a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12 footer-col-block">
                                <div class="footer-heading footer-heading-desktop">
                                    <h6>Pages</h6>
                                </div>
                                <div class="footer-heading footer-heading-moblie">
                                    <h6>Pages</h6>
                                </div>
                                <ul class="footer-menu-list tf-collapse-content">
                                    <li>
                                        <a href="about-us.php" class="footer-menu_item">About Us</a>
                                    </li>
                                    <li>
                                        <a href="contact.php" class="footer-menu_item">Contact Us</a>
                                    </li>
                                    <li>
                                        <a href="my-account.php" class="footer-menu_item">Account</a>
                                    </li>
                                    <li>
                                        <a href="register.php" class="footer-menu_item">Register</a>
                                    </li>
                                    <li>
                                        <a href="login.php" class="footer-menu_item">Login</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="footer-newsletter footer-col-block">
                                    <div class="footer-heading footer-heading-desktop">
                                        <h6>Sign Up for Email</h6>
                                    </div>
                                    <div class="footer-heading footer-heading-moblie">
                                        <h6>Sign Up for Email</h6>
                                    </div>
                                    <div class="tf-collapse-content">
                                        <div class="footer-menu_item">Sign up to get first dibs on new arrivals, sales,
                                            exclusive content, events and more!</div>
                                        <form class="form-newsletter" id="subscribe-form" action="#" method="post"
                                            accept-charset="utf-8" data-mailchimp="true">
                                            <div id="subscribe-content">
                                                <fieldset class="email">
                                                    <input type="email" name="email-form" id="subscribe-email"
                                                        placeholder="Enter your email...." tabindex="0"
                                                        aria-required="true">
                                                </fieldset>
                                                <div class="button-submit">
                                                    <button id="subscribe-button"
                                                        class="tf-btn btn-sm radius-3 btn-fill btn-icon animate-hover-btn"
                                                        type="button">Subscribe<i
                                                            class="icon icon-arrow1-top-left"></i></button>
                                                </div>
                                            </div>
                                            <div id="subscribe-msg"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div
                                    class="footer-bottom-wrap d-flex gap-20 flex-wrap justify-content-center align-items-center">
                                    <div class="footer-menu_item">© 2025 TrendAura Store. All Rights Reserved</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- /Footer -->

        </div>

        <!-- gotop -->
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                    style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 286.138;">
                </path>
            </svg>
        </div>
        <!-- /gotop -->

        <!-- mobile menu -->
        <div class="offcanvas offcanvas-start canvas-mb" id="mobileMenu">
            <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
            <div class="mb-canvas-content">
                <div class="mb-body">
                    <ul class="nav-ul-mb" id="wrapper-menu-navigation">
                    <li class="nav-mb-item">
                            <a href="home.php"
                                class="mb-menu-link">Home</a>
                        </li>
                        <li class="nav-mb-item">
                            <a href="#dropdown-menu-two" class="collapsed mb-menu-link current"
                                data-bs-toggle="collapse" aria-expanded="true" aria-controls="dropdown-menu-two">
                                <span>Shop</span>
                                <span class="btn-open-sub"></span>
                            </a>
                            <div id="dropdown-menu-two" class="collapse">
                                <ul class="sub-nav-menu" id="sub-menu-navigation">
                                    <?php
            // Include database connection
            include('config/db.php');

            // Fetch all categories from the database
            $categories_sql = "SELECT category_id, category_name FROM category";
            $categories_result = mysqli_query($conn, $categories_sql);

            if ($categories_result && mysqli_num_rows($categories_result) > 0) {
                while ($category = mysqli_fetch_assoc($categories_result)) {
                    $category_id = $category['category_id']; // Fetch the ID of the category
            ?>
                                    <li>
                                        <a href="#sub-shop-<?php echo $category_id; ?>" class="sub-nav-link collapsed"
                                            data-bs-toggle="collapse" aria-expanded="false"
                                            aria-controls="sub-shop-<?php echo $category_id; ?>">
                                            <span><?php echo $category['category_name']; ?></span>
                                            <span class="btn-open-sub"></span>
                                        </a>
                                        <?php
                        $subcategories_sql = "SELECT * FROM sub_category WHERE category_id = $category_id";
                        $subcategories_result = mysqli_query($conn, $subcategories_sql);

                        if ($subcategories_result && mysqli_num_rows($subcategories_result) > 0) {
                        ?>
                                        <div id="sub-shop-<?php echo $category_id; ?>" class="collapse">
                                            <ul class="sub-nav-menu sub-menu-level-2">
                                                <?php while ($subcategory = mysqli_fetch_assoc($subcategories_result)) { ?>
                                                <li>
                                                    <a href="shop-default.php?sub_id=<?php echo $subcategory['sub_id']; ?>"
                                                        class="sub-nav-link">
                                                        <?php echo $subcategory['sub_name']; ?>
                                                    </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php
                        } else {
                            echo '<p class="text-muted">No Subcategories</p>';
                        }
                        ?>
                                    </li>
                                    <?php
                }
            } else {
                echo '<p class="text-muted">No Categories Found</p>';
            }
            ?>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-mb-item">
                            <a href="about-us.php"
                                class="mb-menu-link">About Us</a>
                        </li>
                        <?php if ($isLoggedIn): ?>
                        <li class="nav-mb-item">
                            <a href="my-account.php"
                                class="mb-menu-link">My Account</a>
                        </li>
                        <?php else: ?>
                            <a href="login.php" class="site-nav-icon"><i class="icon icon-account"></i>Login</a>
                            <?php endif; ?>
                    </ul>
                    <div class="mb-other-content">
                        <div class="mb-notice">
                            <a href="contact.php" class="text-need">Need help ?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /mobile menu --> 

        <!-- Javascript -->
        <script type="text/javascript" src="front-assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="front-assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="front-assets/js/swiper-bundle.min.js"></script>
        <script type="text/javascript" src="front-assets/js/carousel.js"></script>
        <script type="text/javascript" src="front-assets/js/bootstrap-select.min.js"></script>
        <script type="text/javascript" src="front-assets/js/lazysize.min.js"></script>
        <script type="text/javascript" src="front-assets/js/count-down.js"></script>
        <script type="text/javascript" src="front-assets/js/wow.min.js"></script>
        <script type="text/javascript" src="front-assets/js/multiple-modal.js"></script>
        <script type="text/javascript" src="front-assets/js/main.js"></script>
        </body>

        </html>