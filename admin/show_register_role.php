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
            <div class="app-loader">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <!-- Menu Navigation starts -->
        <?php include('sidebar.php')?>
        <!-- Menu Navigation ends -->
        <div class="app-content">
            <div>

                <!-- Body main section starts -->
                <main>
                    <div class="container-fluid">
                        <!-- Breadcrumb end -->

                        <!-- tables start  -->
                        <div class="row table-section">
                            <!-- Simple Table start -->
                            <div class="col-xl-12">
                                <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Show Registered Roles</h5>
                                    <div>
                                        <input type="text" id="searchBar" class="form-control form-control-sm" placeholder="Search Registered Role">
                                    </div>
                                </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Id</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Profile Picture</th>
                                                        <th scope="col">Phone Number</th>
                                                        <th scope="col">Address</th>
                                                        <th scope="col">Role</th>
                                                        <th scope="col">Action</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="userTableBody">
                                                <?php 
                                                    include('../config/db.php');
                                                    $sql = "SELECT * FROM register INNER JOIN role ON register.role_id = role.role_id";
                                                    $no = 0;
                                                    $result = mysqli_query($conn, $sql);
                                                    while($row = mysqli_fetch_assoc($result)){
                                                        $no = $no + 1;
                                                     ?>
                                                    <tr>
                                                        <td><?php echo $no ?></td>
                                                        <td>
                                                            <p class="mb-0 f-w-500 "><?php echo $row['name'] ?></p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 f-w-500 "><?php echo $row['email'] ?></p>
                                                        </td>
                                                        <td><img src="<?php echo $row['profile_pic']?>" width="100px"
                                                                height="100px"></td>
                                                        <td>
                                                            <p class="mb-0 f-w-500 "><?php echo $row['phone'] ?></p>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0 f-w-500 "><?php echo $row['address'] ?></p>
                                                        </td>
                                                        <td><?php echo $row['role_name']?></td>
                                                        <td class="edit"><a
                                                                href="edit_register_role.php?id=<?php echo $row['id'] ?>"><button
                                                                    class="btn edit-item-btn btn-sm btn-success"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal">Edit</button></a>
                                                        </td>
                                                        <td class="remove"><a
                                                                href="delete_register_role.php?id=<?php echo $row['id'] ?>"><button
                                                                    class="btn remove-item-btn btn-sm btn-danger">Remove</button></a>
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

                <?php include('footer.php')?>
            </div>
        </div>
    </div>

    <!-- Add jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // On keyup event of the search bar, trigger AJAX request
        $(document).ready(function() {
            $("#searchBar").on("keyup", function() {
                var query = $(this).val(); // Get the search query
                $.ajax({
                    url: "fetch_users.php", // This will be the PHP script that handles the search
                    method: "POST",
                    data: { search: query },
                    success: function(response) {
                        // Replace the table body with the new rows returned by PHP
                        $("#userTableBody").html(response);
                    }
                });
            });
        });
    </script>

</body>
