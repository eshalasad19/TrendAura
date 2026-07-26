<?php
if (!isset($_SESSION['admin']) || ($_SESSION['admin']['role_name'] != 'Admin' && $_SESSION['admin']['role_name'] != 'Product Manager' && $_SESSION['admin']['role_name'] != 'Order Dispatcher')) {
    header("Location: login.php"); // Redirect to admin login
    exit();
}

// yaha $role variable define kar lo
$role = $_SESSION['admin']['role_name'];
?>



<!-- Sidebar Navigation -->
<nav>
    <div class="app-logo">
        <a class="logo d-inline-block" href="index.html">
            <img src="../assets/images/logo/logo.png" alt="#">
        </a>
        <span class="bg-light-primary toggle-semi-nav">
            <i class="ti ti-chevrons-right f-s-20"></i>
        </span>
    </div>
    <div class="app-nav" id="app-simple-bar">
        <ul class="main-nav p-0 mt-2">
            <!-- Dashboard -->
            <li class="no-sub">
                <a href="home.php">
                    <i class="ph-duotone ph-house-line"></i> Dashboard
                </a>
            </li>

            <!-- Admin Role -->
            <?php if ($role === 'Admin') { ?>
            <li>
                <a data-bs-toggle="collapse" href="#apps" aria-expanded="false">
                    <i class="ph-duotone ph-briefcase"></i> Role
                </a>
                <ul class="collapse" id="apps">
                    <li><a href="addrole.php">Add Role</a></li>
                    <li><a href="showrole.php">Show Role</a></li>
                    <li><a href="register_role.php">Register Role</a></li>
                    <li><a href="show_register_role.php">Show Registered Roles</a></li>
                </ul>
            </li>
            <?php } ?>

            <!-- Admin and Product Manager -->
            <?php if (in_array($role, ['Admin', 'Product Manager'])) { ?>
            <li>
                <a data-bs-toggle="collapse" href="#ui-kits" aria-expanded="false">
                    <i class="ph ph-copy"></i> Category
                </a>
                <ul class="collapse" id="ui-kits">
                    <li><a href="addcategory.php">Add Category</a></li>
                    <li><a href="showcategory.php">Show Category</a></li>
                    <li><a href="add_sub_category.php">Add Sub-Category</a></li>
                    <li><a href="show_sub_category.php">Show Sub-Category</a></li>
                </ul>
            </li>
            <li>
                <a data-bs-toggle="collapse" href="#advance-ui" aria-expanded="false">
                    <i class="ph ph-shopping-bag"></i> Products
                </a>
                <ul class="collapse" id="advance-ui">
                    <li><a href="add_product.php">Add Products</a></li>
                    <li><a href="showproduct.php">Show Products</a></li>
                </ul>
            </li>
            <?php } ?>

            <!-- Admin Only -->
            <?php if ($role === 'Admin') { ?>
            <li>
                <a data-bs-toggle="collapse" href="#icons" aria-expanded="false">
                    <i class="ph ph-sliders-horizontal"></i> Slider
                </a>
                <ul class="collapse" id="icons">
                    <li><a href="addslider.php">Add Slider</a></li>
                    <li><a href="showslider.php">Show Slider</a></li>
                </ul>
            </li>
            <li>
                <a data-bs-toggle="collapse" href="#maps" aria-expanded="false">
                    <i class="ph ph-pencil-simple"></i> About Us
                </a>
                <ul class="collapse" id="maps">
                    <li><a href="add_about.php">Add About Us</a></li>
                    <li><a href="show_about.php">Show About Us</a></li>
                </ul>
            </li>
            <?php } ?>

            <!-- Common for All Roles -->
            <li class="no-sub">
                <a href="show_order.php">
                    <i class="ph ph-truck"></i> Orders
                </a>
            </li>
            <li class="no-sub">
                <a href="best_seller.php">
                    <i class="ph ph-users"></i> Best Seller
                </a>
            </li>
            <li class="no-sub">
                <a href="best_selling_product.php">
                    <i class="ph ph-tag"></i> Top Selling Products
                </a>
            </li>
        </ul>
    </div>
    <div class="menu-navs">
        <span class="menu-previous"><i class="ti ti-chevron-left"></i></span>
        <span class="menu-next"><i class="ti ti-chevron-right"></i></span>
    </div>
</nav>
