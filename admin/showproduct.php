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
                        <!-- <div class="row m-1">
                            <div class="col-12 ">
                                <h5>Show Products</h5>
                            </div>
                        </div> -->
                        <br>
                        <!-- Breadcrumb end -->

                        <!-- tables start -->
                        <div class="row table-section">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5>Show Products</h5>
                                        <div>
                                            <input type="text" id="searchBar" class="form-control form-control-sm" placeholder="Search Product">
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0" id="productTable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Id</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Description</th>
                                                        <th scope="col">Image</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Stock</th>
                                                        <th scope="col">Category</th>
                                                        <th scope="col">Sub-Category</th>
                                                        <th scope="col">Action</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- AJAX content will load here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- tables-end -->
                    </div>
                </main>
                <!-- Body main section ends -->

                <div class="go-top">
                    <span class="progress-value">
                        <i class="ti ti-arrow-up"></i>
                    </span>
                </div>

                <?php include('footer.php') ?>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Trigger the search when the user types in the search bar
            $('#searchBar').on('input', function() {
                var searchQuery = $(this).val();
                fetchSearchResults(searchQuery); // Call function to fetch filtered results
            });

            // Function to fetch the search results
            function fetchSearchResults(searchQuery) {
                $.ajax({
                    url: 'search_product.php', // PHP file that handles search and returns the result
                    method: 'POST',
                    data: { search: searchQuery }, // Send the search query to the PHP file
                    success: function(response) {
                        $('#productTable tbody').html(response); // Update the table with the search results
                    }
                });
            }

            // Initially load all the entries
            fetchSearchResults('');
        });
    </script>
</body>
