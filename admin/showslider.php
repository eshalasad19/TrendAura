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
                                        <h5>Show Sliders</h5>
                                        <div>
                                            <input type="text" id="searchBar" class="form-control form-control-sm" placeholder="Search Slider">
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0" id="sliderTable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Id</th>
                                                        <th scope="col">Title</th>
                                                        <th scope="col">Description</th>
                                                        <th scope="col">Image</th>
                                                        <th scope="col">Action</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Sliders will be loaded dynamically using AJAX -->
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

            function fetchSearchResults(searchQuery) {
                $.ajax({
                    url: 'fetch_slider.php', // PHP script that handles search
                    method: 'POST',
                    data: { search: searchQuery }, // Send the search query to the PHP file
                    success: function(response) {
                        $('#sliderTable tbody').html(response); // Update the table with the search results
                    }
                });
            }

            // Load all sliders initially (when the page loads)
            fetchSearchResults('');
        });
    </script>

</body>
</html>
