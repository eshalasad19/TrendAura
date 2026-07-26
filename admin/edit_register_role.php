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
                            <h4 class="main-title">Update Registered Role</h4>
                        </div>
                    </div>
                    <br>
                    <!-- Breadcrumb end -->

                    <?php
include('../config/db.php');
$id = $_GET['id'] ?? '';
if (!ctype_digit((string)$id)) { die('Invalid ID.'); }

// Fetch existing data for pre-filling the form
$sql = "SELECT * FROM register WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Update Registered Role Form</h5>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data" class="app-form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label"> Name</label>
                                <input type="text" class="form-control" placeholder="Enter Your Name" name="name" required="" value="<?php echo $row['name']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Enter Your Email" name="email" required="" value="<?php echo $row['email']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" placeholder="Enter Password" name="password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" placeholder="Confirm Password" name="cpassword">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Previous Picture</label>
                                <br>
                                <input type="hidden" name="pic" value="<?php echo $row['profile_pic']; ?>">
                                <img src="<?php echo $row['profile_pic']; ?>" width="150" height="150">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Update Picture</label>
                                <input type="file" class="form-control" name="picture">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="number" class="form-control" placeholder="Enter Phone Number" name="number" required="" maxlength="11" value="<?php echo $row['phone']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" placeholder="Enter Address" name="address" required="" value="<?php echo $row['address']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Choose a Role:</label>
                                <select name="role" class="form-control">
                                    <?php
                                    $sql = "SELECT * FROM role";
                                    $roles = mysqli_query($conn, $sql);
                                    while ($role = mysqli_fetch_assoc($roles)) {
                                        $selected = $role['role_id'] == $row['role_id'] ? 'selected' : '';
                                        echo "<option value='{$role['role_id']}' $selected>{$role['role_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" name="update">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $pre_picture = $_POST['pic'];

    // Handle profile picture update
    $imgName = $_FILES['picture']['name'];
    $temping = $_FILES['picture']['tmp_name'];
    $imagePath = "../image/" . $imgName;

    // Password Handling
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['cpassword'];
    $hashedPassword = $row['password']; // Default to old password

    if (!empty($newPassword)) {
        if ($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        } else {
            echo "<script>adminToast('Passwords do not match', 'error');</script>";
            exit;
        }
    }

    // Update query
    if (empty($imgName)) {
        $sql = "UPDATE register SET name = ?, email = ?, password = ?, profile_pic = ?, phone = ?, address = ?, role_id = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssii", $name, $email, $hashedPassword, $pre_picture, $number, $address, $role, $id);
        $updatedPicture = $pre_picture;
    } else {
        if (move_uploaded_file($temping, $imagePath)) {
            $sql = "UPDATE register SET name = ?, email = ?, password = ?, profile_pic = ?, phone = ?, address = ?, role_id = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssii", $name, $email, $hashedPassword, $imagePath, $number, $address, $role, $id);
            $updatedPicture = $imagePath;
        } else {
            echo "<script>adminToast('File upload failed', 'error');</script>";
            exit;
        }
    }

    if (mysqli_stmt_execute($stmt)) {
        // Update session variables for real-time update
        $_SESSION['username'] = $name;
        $_SESSION['profile_pic'] = $updatedPicture; // Update the session with new picture

        echo "<script>adminToast('Role updated successfully', 'success'); setTimeout(function(){ location.replace('show_register_role.php'); }, 1200);</script>";
    } else {
        echo "<script>adminToast('Update failed: " . mysqli_error($conn) . "', 'error');</script>";
    }
}
?>

                    <!-- Book Appointment Form end -->
                </div>
                <!-- ready to use form and -->
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