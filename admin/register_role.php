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
            <!-- Body main section starts -->
            <main>
                <div class="container-fluid">
                    <!-- Breadcrumb start -->
                    <div class="row m-1">
                        <div class="col-12 ">
                            <h4 class="main-title">Role</h4>
                        </div>
                    </div>
                    <br>
                    <!-- Breadcrumb end -->

                    <!-- form start -->
                    <?php 
include('../config/db.php');
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $imgName = $_FILES['picture']['name'];
    $temping = $_FILES['picture']['tmp_name'];
    $imagePath = "../image/" . $imgName;

    // Check if passwords match
    if ($password === $cpassword) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (move_uploaded_file($temping, $imagePath)) {
            $sql = "INSERT INTO `register` (name, email, password, profile_pic, phone, address, role_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssss", $name, $email, $hashedPassword, $imagePath, $number, $address, $role);
            $result = mysqli_stmt_execute($stmt);
            
            if ($result) {
                echo "<script>location.replace('show_register_role.php')</script>";
            } else {
                echo mysqli_error($conn);
            }
        } else {
           echo "<script>adminToast('File upload failed', 'error');</script>";
        }
    } else {
        echo "<script>adminToast('Passwords do not match', 'error');</script>";
    }
}
?>



                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                <h5>Register Role</h5>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data" class="app-form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label"> Name</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Your Name" name="name" required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control"
                                                        placeholder="Enter Your Email" name="email" required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" class="form-control"
                                                        placeholder="Enter Password" name="password" required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Confirm Password</label>
                                                    <input type="password" class="form-control"
                                                        placeholder="Confirm Password" name="cpassword" required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Profile Picture</label>
                                                    <input type="file" class="form-control"
                                                        placeholder="Profile Picture" name="picture" required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Phone Number</label>
                                                    <input type="number" class="form-control"
                                                        placeholder="Enter Phone Number" name="number" required=""
                                                        maxlength="11">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" class="form-control" placeholder="Enter Address"
                                                        name="address" required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="role">Choose a Role:</label>

                                                    <select name="role" id="role" class="form-control">
    <?php
    include('../config/db.php');
    // ✅ Only roles except "User"
    $sql = "SELECT * FROM role WHERE role_name != 'User'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
    ?>
        <option value="<?php echo $row['role_id'] ?>">
            <?php echo $row['role_name'] ?>
        </option>
    <?php } ?>
</select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary"
                                                        name="submit">Submit</button>
                                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- form end -->
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