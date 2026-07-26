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

                        <!-- tables start  -->
                        <div class="row table-section">
                            <!-- Simple Table start -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5>Show Orders</h5>
                                        <div>
                                            <input type="text" id="searchBar" class="form-control form-control-sm" placeholder="Search Orders">
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0" id="ordersTable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Id</th>
                                                        <th scope="col">Username</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">City</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Payment</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Product Name</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Edit</th>
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
                        <i class="ph-bold ph-arrow-up"></i>
                    </span>
                </div>

                <?php include('footer.php') ?>
            </div>
        </div>
    </div>

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
                    url: 'fetch_orders.php', // PHP file that handles search and returns the result
                    method: 'POST',
                    data: { search: searchQuery }, // Send the search query to the PHP file
                    success: function(response) {
                        $('#ordersTable tbody').html(response); // Update the table with the search results
                    }
                });
            }

            // Initially load all the entries
            fetchSearchResults('');
        });
    </script>

</body>
</html>
