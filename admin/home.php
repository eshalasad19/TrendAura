<?php include('header.php')?>
<?php include('navbar.php')?>
<?php
if (!isset($_SESSION['admin']) || ($_SESSION['admin']['role_name'] != 'Admin' && $_SESSION['admin']['role_name'] != 'Product Manager' && $_SESSION['admin']['role_name'] != 'Order Dispatcher')) {
    header("Location: login.php"); // Redirect to admin login
    exit();
}
?>

<body>
    <div class="app-wrapper">

        <div class="loader-wrapper">
            <div class="loader_16"></div>
        </div>
        <!-- Menu Navigation starts -->
        <?php include('sidebar.php')?>
        <!-- Menu Navigation ends -->
        <div class="app-content">
            <div class="">
                <!-- Navbar Section starts -->
                <!-- Body main section starts -->
                <main>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-xxl-12">
                                <div class="row">
                                    <?php
                                    include('../config/db.php');
                                $sql = "SELECT COUNT(*) AS total_users FROM register r 
        JOIN role ro ON r.role_id = ro.role_id 
        WHERE ro.role_name = 'user'";
$result = $conn->query($sql);

// Fetch the count
$total_users = 0; // Default value
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_users = $row['total_users'];
}
?>
                                <div class="col-sm-6">
        <div class="card eshop-cards">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="bg-primary h-40 w-40 d-flex-center b-r-15 f-s-18">
                        <i class="ph-bold ph-map-pin-line"></i>
                    </span>
                    <div class="dropdown"></div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-shrink-0 align-self-end">
                        <p class="f-s-16 mb-0">Total Users</p>
                        <h5><?php echo $total_users; ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include('../config/db.php');
    $sql = "SELECT COUNT(*) AS total_orders FROM `orderr`";
$result = $conn->query($sql);

// Fetch the count
$total_orders = 0; // Default value
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_orders = $row['total_orders'];
}
?>
                                    <div class="col-sm-6">
                                        <div class="card eshop-cards">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="bg-secondary h-40 w-40 d-flex-center b-r-15 f-s-18">
                                                        <i class="ph-bold  ph-shopping-cart"></i>
                                                    </span>
                                                </div>
                                                <div
                                                    class="d-flex justify-content-between align-items-center position-relative">
                                                    <div class="flex-shrink-0 align-self-end">
                                                        <p class="f-s-16 mb-0">Order</p>
                                                        <h5><?php echo $total_orders?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    include('../config/db.php');
                                    $sql = "SELECT COUNT(*) AS total_products FROM product";
$result = $conn->query($sql);

// Fetch the count
$total_products = 0; // Default value
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_products = $row['total_products'];
}
?>
                                    <div class="col-sm-6">
                                        <div class="card eshop-cards">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="bg-success h-40 w-40 d-flex-center b-r-15 f-s-18">
                                                        <i class="ph-bold  ph-pulse"></i>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="flex-shrink-0 align-self-end">
                                                        <p class="f-s-16 mb-0">Products</p>
                                                        <h5><?php echo $total_products ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
include('../config/db.php');

// Revenue only counts DELIVERED orders — that's when money is actually
// received (COD is paid on delivery), not just when an order is placed.
$sql = "SELECT SUM(p.product_price * oi.quantity) AS total_price 
        FROM order_item oi
        JOIN product p ON oi.product_id = p.product_id
        JOIN orderr o ON oi.order_id = o.order_id
        WHERE o.status = 'Delivered'";

$result = $conn->query($sql);
$total_price = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_price = $row['total_price'] ?? 0;
}
?>
                                    <div class="col-sm-6">
                                        <div class="card eshop-cards">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="bg-warning h-40 w-40 d-flex-center b-r-15 f-s-18">
                                                        <i class="ph-fill  ph-coins"></i>
                                                    </span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="flex-shrink-0 align-self-end">
                                                        <p class="f-s-16 mb-0">Sales <span style="font-size:11px;color:#909090;">(Delivered)</span></p>
                                                        <h5>Rs. <?php echo number_format($total_price, 2); ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            // ---- Sales trend: last 14 days revenue ----
                            include('../config/db.php');
                            $trend_sql = "SELECT DATE(o.orderdate) AS d, SUM(oi.quantity * oi.price) AS revenue
                                          FROM orderr o
                                          JOIN order_item oi ON oi.order_id = o.order_id
                                          WHERE o.orderdate >= DATE_SUB(CURDATE(), INTERVAL 13 DAY)
                                          AND o.status = 'Delivered'
                                          GROUP BY DATE(o.orderdate)";
                            $trend_result = $conn->query($trend_sql);
                            $trend_map = [];
                            if ($trend_result) {
                                while ($r = $trend_result->fetch_assoc()) {
                                    $trend_map[$r['d']] = (float) $r['revenue'];
                                }
                            }
                            $trend_labels = [];
                            $trend_values = [];
                            for ($i = 13; $i >= 0; $i--) {
                                $d = date('Y-m-d', strtotime("-$i days"));
                                $trend_labels[] = date('M j', strtotime($d));
                                $trend_values[] = $trend_map[$d] ?? 0;
                            }

                            // ---- Order status breakdown ----
                            $status_sql = "SELECT status, COUNT(*) AS cnt FROM orderr GROUP BY status";
                            $status_result = $conn->query($status_sql);
                            $status_labels = [];
                            $status_values = [];
                            if ($status_result) {
                                while ($r = $status_result->fetch_assoc()) {
                                    $status_labels[] = $r['status'];
                                    $status_values[] = (int) $r['cnt'];
                                }
                            }

                            // ---- Low stock alert (10 or fewer left) ----
                            $low_stock_sql = "SELECT product_name, stock FROM product WHERE stock <= 10 ORDER BY stock ASC LIMIT 8";
                            $low_stock_result = $conn->query($low_stock_sql);
                            ?>

                            <div class="col-lg-8 col-xxl-8">
                                <div class="card equal-card">
                                    <div class="card-header card-header-title">
                                        <h5>Sales Trend</h5>
                                        <p class="text-secondary mb-0">Last 14 days</p>
                                    </div>
                                    <div class="card-body">
                                        <div id="salesTrendChart"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xxl-4">
                                <div class="card equal-card">
                                    <div class="card-header card-header-title">
                                        <h5>Orders by Status</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="orderStatusChart"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-xxl-12">
                                <div class="card equal-card">
                                    <div class="card-header card-header-title">
                                        <h5>Low Stock Alert</h5>
                                        <p class="text-secondary mb-0">10 or fewer left</p>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($low_stock_result && $low_stock_result->num_rows > 0): ?>
                                            <div class="table-responsive app-scroll">
                                                <table class="table align-middle mb-0">
                                                    <thead><tr><th>Product</th><th>Stock Left</th></tr></thead>
                                                    <tbody>
                                                        <?php while ($lp = $low_stock_result->fetch_assoc()): ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($lp['product_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                                <td><span class="badge bg-<?php echo $lp['stock'] == 0 ? 'danger' : 'warning'; ?>"><?php echo (int) $lp['stock']; ?></span></td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-secondary mb-0">All products are well stocked.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <script>
                                // Wait for the window 'load' event — apexcharts.min.js is included in
                                // footer.php, which loads AFTER this script tag in the page. Without this,
                                // ApexCharts wouldn't exist yet when this code runs and the charts would
                                // silently fail to render.
                                window.addEventListener('load', function () {
                                    var salesTrendChart = new ApexCharts(document.querySelector("#salesTrendChart"), {
                                        series: [{ name: 'Revenue (Rs.)', data: <?php echo json_encode($trend_values); ?> }],
                                        chart: { type: 'area', height: 260, toolbar: { show: false } },
                                        colors: ['#db1215'],
                                        stroke: { curve: 'smooth', width: 2 },
                                        xaxis: { categories: <?php echo json_encode($trend_labels); ?> },
                                        dataLabels: { enabled: false },
                                        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.05 } }
                                    });
                                    salesTrendChart.render();

                                    var orderStatusChart = new ApexCharts(document.querySelector("#orderStatusChart"), {
                                        series: <?php echo json_encode($status_values); ?>,
                                        labels: <?php echo json_encode($status_labels); ?>,
                                        chart: { type: 'donut', height: 260 },
                                        colors: ['#b56a00', '#0d6efd', '#6f42c1', '#1a9c5b', '#db1215'],
                                        legend: { position: 'bottom' }
                                    });
                                    orderStatusChart.render();
                                });
                            </script>

                            <?php
include('../config/db.php');

$sql = "SELECT 
            p.product_name, 
            sc.sub_name AS category_name, 
            SUM(oi.quantity) AS total_quantity_sold, 
            SUM(oi.quantity * p.product_price) AS total_revenue
        FROM order_item oi
        JOIN product p ON oi.product_id = p.product_id
        JOIN sub_category sc ON p.sub_cat_id = sc.sub_id
        JOIN orderr o ON oi.order_id = o.order_id
        WHERE o.status != 'Cancelled'
        GROUP BY p.product_id, p.product_price
        ORDER BY total_quantity_sold DESC";

$result = $conn->query($sql);
?>
                            <div class="col-md-12 col-xxl-12">
        <div class="card equal-card top-product-card">
            <div class="card-header card-header-title">
                <h5>Top Products</h5>
                <p class="text-secondary mb-0">Latest Report</p>
            </div>
            <div class="card-body">
                <div class="table-responsive app-scroll">
                    <table class="table align-middle top-products-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Category</th>
                                <th scope="col">Quantity Sold</th>
                                <th scope="col">Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['product_name']; ?></td>
                                        <td><?php echo $row['category_name']; ?></td>
                                        <td><?php echo $row['total_quantity_sold']; ?></td>
                                        <td><?php echo number_format($row['total_revenue'], 2); ?> PKR</td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">No data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
                        </div>

                    </div>
                </main>
            </div>
        </div>
        <!-- Body main section ends -->


        <!-- tap on top -->
        <div class="go-top">
            <span class="progress-value">
                <i class="ph-bold ph-arrow-up"></i>
            </span>
        </div>
        <?php include('footer.php')?>