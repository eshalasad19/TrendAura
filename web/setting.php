<?php
$page_title = 'Account Settings';
$page_description = 'Manage your TrendAura account settings.';
include('include/header.php');
include('include/navbar.php');
include('config/db.php');

// session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] != 'User') {
    header("Location: login.php");
    exit();
}

// Get logged-in user id
$user_id = $_SESSION['user']['user_id'];

// Fetch user details
$sql = "SELECT * FROM register WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
?>

<!-- page-title -->
<div class="tf-page-title">
    <div class="container-full">
        <div class="heading text-center">Account Settings</div>
    </div>
</div>
<!-- /page-title -->

<section class="flat-spacing-11">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="wrap-sidebar-account">
                    <ul class="my-account-nav">
                        <li><a href="my-account.php" class="my-account-nav-item">Orders</a></li>
                        <li><a href="setting.php" class="my-account-nav-item active">Settings</a></li>
                        <li><a href="logout.php" class="my-account-nav-item">Logout</a></li>
                    </ul>
                </div>
            </div>

            <!-- User Info -->
            <div class="col-lg-9">
                <div class="my-account-content account-details p-4 shadow radius-10 text-center" 
                     style="background:#fff; border:1px solid #eee;">
                    
                    <h4 class="mb_30 fw-6" style="font-size:26px; font-family:'Poppins', sans-serif; color:#333;">
                        Your Profile Information
                    </h4>

                    <div class="account-info" style="font-size:18px; line-height:1.8; font-family:'Roboto', sans-serif; color:#444;">
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>

                        <div class="mt_30">
                            <strong>Profile Picture:</strong><br>
                            <?php if (!empty($user['profile_pic'])): ?>
                                <img src="<?php echo $user['profile_pic']; ?>" alt="Profile Picture"
                                     style="width:120px; height:120px; border-radius:50%; object-fit:cover; margin-top:10px;">
                            <?php else: ?>
                                <img src="default-avatar.png" alt="Default Profile"
                                     style="width:120px; height:120px; border-radius:50%; object-fit:cover; margin-top:10px;">
                            <?php endif; ?>
                        </div>
                        <br>

                        <!-- Update Button -->
                        <div class="mt_40">
                            <a href="update-profile.php" 
                               class="tf-btn btn-fill radius-3 btn-xl animate-hover-btn" 
                               style="padding:6px 35px; font-size:18px;">
                                Update Profile
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<div class="btn-sidebar-account">
    <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount" aria-controls="offcanvas">
        <i class="icon icon-sidebar-2"></i>
    </button>
</div>

<?php include('include/footer.php'); ?>
