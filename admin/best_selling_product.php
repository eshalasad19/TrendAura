<?php include('header.php') ?>
<?php include('navbar.php') ?>
<?php
if (!isset($_SESSION['admin']) || ($_SESSION['admin']['role_name'] != 'Admin' && $_SESSION['admin']['role_name'] != 'Product Manager' && $_SESSION['admin']['role_name'] != 'Order Dispatcher')) {
    header("Location: login.php"); // Redirect to admin login
    exit();
}
?>

<body>
    <div class="app-wrapper">

        <div class="loader-wrapper">
            <div class="app-loader">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <!-- Menu Navigation starts -->
        <?php include('sidebar.php') ?>
        <!-- Menu Navigation ends -->

        <div class="app-content">
            <div>

                <!-- Body main section starts -->
                <main>
                    <div class="container-fluid">
                        <!-- Breadcrumb start -->
                        <br>
                        <!-- Breadcrumb end -->

                        <!-- tables start -->
                        <div class="row table-section">
                            <!-- Simple Table start -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5>Top Selling Products</h5>
                                        <div>
                                            <input type="text" id="searchBar" class="form-control form-control-sm" placeholder="Search Products">
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0" id="productsTable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Id</th>
                                                        <th scope="col">Product Name</th>
                                                        <th scope="col">Product Image</th>
                                                        <th scope="col">Product Price</th>
                                                        <th scope="col">Stock</th>
                                                        <th scope="col">Total Quantity Sold</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Rows will be populated dynamically by AJAX -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Simple Table end -->
                        </div>
                        <!-- tables-end  -->
                    </div>
                </main>
                <!-- Body main section ends -->

                <!-- tap on top -->
                <div class="go-top">
                    <span class="progress-value">
                        <i class="ti ti-arrow-up"></i>
                    </span>
                </div>

                <?php include('footer.php') ?>
            </div>
        </div>
    </div>

    <!-- jQuery library for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Trigger search on input change
            $('#searchBar').on('input', function () {
                var searchQuery = $(this).val();
                fetchProducts(searchQuery); // Fetch and update the products list dynamically
            });

            // Function to fetch filtered products
            function fetchProducts(searchQuery) {
                $.ajax({
                    url: 'fetch_top_selling_products.php', // PHP file to process the search query
                    method: 'POST',
                    data: { search: searchQuery },
                    success: function (response) {
                        $('#productsTable tbody').html(response); // Update the table with search results
                    }
                });
            }

            // Initially load all products
            fetchProducts('');
        });
    </script>

</body>
</html>
