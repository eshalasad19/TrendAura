<?php
include('config/db.php'); 
include('auth_check.php');
$page_title = 'Update Profile';
$page_description = 'Update your TrendAura profile information.';
include('include/header.php');
include('include/navbar.php');?>
<script>
    window.TOAST_REDIRECT_SUCCESS = 'view-cart.php';
    window.TOAST_REDIRECT_ERROR = 'login.php';
</script>
<?php

// session_start();

// Ensure user is logged in
if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] != 'User') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user']['user_id'];

// Fetch current user details
$sql = "SELECT * FROM register WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Handle form submission
if (isset($_POST['update'])) {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $phone   = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $profile_picture = $_FILES['profile_picture'];

    $profile_path = $user['profile_pic']; // Default old pic

    // If new profile picture uploaded
    if (!empty($profile_picture['name'])) {
        $target_dir = "../image/";
        $target_file = $target_dir . basename($profile_picture['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (in_array($imageFileType, ['jpg','jpeg','png','gif'])) {
            if (move_uploaded_file($profile_picture['tmp_name'], $target_file)) {
                $profile_path = $target_file;
            }
        }
    }

    // Update query
    $update_sql = "UPDATE register 
                   SET name=?, email=?, phone=?, address=?, profile_pic=? 
                   WHERE id=?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "sssssi", $name, $email, $phone, $address, $profile_path, $user_id);

    if (mysqli_stmt_execute($update_stmt)) {
        // Update session values too
        $_SESSION['user']['username'] = $name;
        $_SESSION['user']['profile_pic'] = $profile_path;

        echo "<script>showToast('Profile updated successfully', 'success');</script>";
        echo "<script>window.location='setting.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!-- page-title -->
<div class="tf-page-title style-2">
    <div class="container-full">
        <div class="heading text-center">Update Profile</div>
    </div>
</div>
<!-- /page-title -->

<section class="flat-spacing-10">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="wrap-sidebar-account">
                    <ul class="my-account-nav">
                        <li><a href="my-account.php" class="my-account-nav-item">Orders</a></li>
                        <li><a href="setting.php" class="my-account-nav-item">Settings</a></li>
                        <li><a href="logout.php" class="my-account-nav-item">Logout</a></li>
                    </ul>
                </div>
            </div>

            <!-- Form -->
            <div class="col-lg-9">
                <div class="form-register-wrap shadow p-4" style="background:#fff; border:1px solid #eee; border-radius:10px;">
                    <div class="flat-title align-items-start gap-0 mb_30 px-0">
                        <h5 class="mb_18">Update Your Information</h5>
                    </div>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="tf-field style-1 mb_15">
                            <input class="tf-field-input tf-input" type="text" name="name" 
                                   value="<?php echo htmlspecialchars($user['name']); ?>" required>
                            <label class="tf-field-label fw-4 text_black-2">Name</label>
                        </div>

                        <div class="tf-field style-1 mb_15">
                            <input class="tf-field-input tf-input" type="email" name="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            <label class="tf-field-label fw-4 text_black-2">Email</label>
                        </div>

                        <div class="tf-field style-1 mb_15">
                            <input class="tf-field-input tf-input" type="tel" name="phone" 
                                   value="<?php echo htmlspecialchars($user['phone']); ?>">
                            <label class="tf-field-label fw-4 text_black-2">Phone Number</label>
                        </div>

                        <div class="tf-field style-1 mb_15">
                            <input class="tf-field-input tf-input" type="text" name="address" 
                                   value="<?php echo htmlspecialchars($user['address']); ?>">
                            <label class="tf-field-label fw-4 text_black-2">Address</label>
                        </div>

                        <label class="fw-4 text_black-2">Profile Picture</label>
                        <div class="mb_15">
                            <?php if (!empty($user['profile_pic'])): ?>
                                <img src="<?php echo $user['profile_pic']; ?>" 
                                     alt="Current Picture" 
                                     style="width:100px; height:100px; border-radius:50%; object-fit:cover; margin-bottom:10px;">
                            <?php endif; ?>
                            <br>
                            <input class="tf-field-input tf-input" type="file" name="profile_picture" style="padding-bottom:40px;">
                        </div>

                        <div class="mb_20">
                            <button type="submit" name="update"
                                    class="tf-btn w-100 radius-3 btn-fill animate-hover-btn justify-content-center">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('include/footer.php'); ?>