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
            <main>
                <div class="container-fluid">
                    <!-- tables start -->
                    <div class="row table-section">
                        <!-- Simple Table start -->
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Show Roles</h5>
                                    <div>
                                        <input type="text" id="searchBar" class="form-control form-control-sm" placeholder="Search Role">
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Id</th>
                                                    <th scope="col">Role Name</th>
                                                    <th scope="col">Action</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="roleTableBody">
                                                <?php
                                                include('../config/db.php');
                                                $sql = "SELECT * FROM role";
                                                $no = 0;
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $no = $no + 1;
                                                ?>
                                                    <tr>
                                                        <td><?php echo $no ?></td>
                                                        <td>
                                                            <p class="mb-0 f-w-500 "><?php echo $row['role_name'] ?></p>
                                                        </td>
                                                        <td class="edit"><a href="editrole.php?role_id=<?php echo $row['role_id'] ?>"><button class="btn edit-item-btn btn-sm btn-success">Edit</button></a>
                                                        </td>
                                                        <td class="remove"><a href="deleterole.php?role_id=<?php echo $row['role_id'] ?>"><button class="btn remove-item-btn btn-sm btn-danger">Remove</button></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Simple Table end -->
                    </div>
                    <!-- tables-end -->
                </div>
            </main>

            <!-- tap on top -->
            <div class="go-top">
                <span class="progress-value">
                    <i class="ph-bold ph-arrow-up"></i>
                </span>
            </div>

            <?php include('footer.php') ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#searchBar").on("keyup", function () {
                let query = $(this).val(); // Get the input value

                // Perform an AJAX request
                $.ajax({
                    url: "search_roles.php", // PHP file to handle the search
                    method: "POST",
                    data: { search: query },
                    success: function (response) {
                        $("#roleTableBody").html(response); // Update the table body with search results
                    }
                });
            });
        });
    </script>
</body>
