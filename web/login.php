<?php
$page_title = 'Login';
$page_description = 'Log in to your TrendAura account to track orders and manage your profile.';
include('include/header.php');
 include('include/navbar.php');
// session_start(); 
include('config/db.php');
require_once('../config/csrf.php'); ?>
<script>
    window.TOAST_REDIRECT_SUCCESS = 'view-cart.php';
    window.TOAST_REDIRECT_ERROR = 'login.php';
</script>
<?php

if (isset($_POST['login'])) {
    require_csrf();
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check user role and validate login
    $sql = "SELECT * FROM register WHERE email = ? AND role_id = (SELECT role_id FROM role WHERE role_name = 'User')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Set session for logged-in user
            $_SESSION['user'] = [
                'user_id' => $row['id'],
                'username' => $row['name'],
                'email' => $row['email'], // Add email to session
                'profile_pic' => $row['profile_pic'],
                'role_name' => 'User', // Fixed to "User"
            ];

            // Redirect to user account page
            echo "<script>location.replace('home.php')</script>";
            exit();
        } else {
            // Invalid password
            echo "<script>ShowToast('Invalid password.', 'error');</script>";
        }
    } else {
        // User not found
        echo "<script>showToast('User not found.', 'error');</script>";
    }
}
?>

        <!-- page-title -->
        <div class="tf-page-title style-2">
            <div class="container-full">
                <div class="heading text-center">Log in</div>
            </div>
        </div>
        <!-- /page-title -->
    
        <section class="flat-spacing-10">
            <div class="container">
                <div class="tf-grid-layout lg-col-2 tf-login-wrap">
                    <div class="tf-login-form">
                        <div id="login">
                            <h5 class="mb_36">Log in</h5>
                            <div>
                                <form class="" method="post" id="login-form" action="#" accept-charset="utf-8">
                                    <?php echo csrf_field(); ?>
                                    <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder="" type="email" id="property3" name="email">
                                        <label class="tf-field-label fw-4 text_black-2" for="property3">Email</label>
                                    </div>
                                    <div class="tf-field style-1 mb_30">
                                        <input class="tf-field-input tf-input" placeholder="" type="password" id="property4" name="password">
                                        <label class="tf-field-label fw-4 text_black-2" for="property4">Password</label>
                                    </div>
                                    <div class="">
                                        <button type="submit" name="login" class="tf-btn w-100 radius-3 btn-fill animate-hover-btn justify-content-center">Log in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tf-login-content">
                        <h5 class="mb_36">I'm new here</h5>
                        <p class="mb_20">Sign up for early Sale access plus tailored new arrivals, trends and promotions. To opt out, click unsubscribe in our emails.</p>
                        <a href="register.php" class="tf-btn btn-line">Register<i class="icon icon-arrow1-top-left"></i></a>
                    </div>
                </div>
            </div>
        </section>


        <?php include('include/footer.php') ?>