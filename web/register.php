<?php
$page_title = 'Create Account';
$page_description = 'Create your free TrendAura account to track orders, save favorites, and check out faster.';
include('include/header.php') ?>
<?php include('include/navbar.php') ?>


        <!-- page-title -->
        <div class="tf-page-title style-2">
            <div class="container-full">
                <div class="heading text-center">Register</div>
            </div>
        </div>
        <!-- /page-title -->

        <section class="flat-spacing-10">
            <?php
include('config/db.php');
require_once('../config/csrf.php');

// Only show detailed PHP errors in local development, never in production.
error_reporting(E_ALL);
ini_set('display_errors', env('APP_ENV', 'local') === 'local' ? 1 : 0);

if (isset($_POST['submit'])) {
    require_csrf();
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $roleid = $_POST['user_id'];
    $profile_picture = $_FILES['profile_picture'];

    // Check if email already exists
    $check = "SELECT * FROM `register` WHERE email = ?";
    $check_stmt = mysqli_prepare($conn, $check);
    mysqli_stmt_bind_param($check_stmt, "s", $email);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);

    if (!$result) {
        die("Query Failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        echo "<script>showToast('Email already exists', 'error');</script>";
    } else {
        if ($password === $cpassword) {
            // Handle profile picture upload
            $target_dir = "../image/"; // Directory to save uploaded files
            $target_file = $target_dir . basename($profile_picture['name']);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file is an actual image
            $check = getimagesize($profile_picture['tmp_name']);
            if ($check === false) {
                echo "<script>showToast('File is not an image', 'error');</script>";
                $uploadOk = 0;
            }

            // Allow only specific file formats
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo "<script>showToast('Only JPG, JPEG, PNG & GIF files are allowed', 'error');</script>";
                $uploadOk = 0;
            }

            // Upload file if validation passes
            if ($uploadOk && move_uploaded_file($profile_picture['tmp_name'], $target_file)) {
                // Hash the password
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // Insert into the database
                $sql = "INSERT INTO `register` (`name`, `email`, `password`, `phone`, `address`, `role_id`, `profile_pic`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssssss", $name, $email, $hash, $number, $address, $roleid, $target_file);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    echo "<script>showToast('Registration Successfull!', 'success');</script>";
                    echo "<script>location.replace('login.php');</script>";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "<script>showToast('Failed to upload profile picture', 'error');</script>";
            }
        } else {
            echo "<script>showToast('Passwords do not match', 'error');</script>";
        }
    }
}
?>

            <div class="container">
                <div class="form-register-wrap">
                    <div class="flat-title align-items-start gap-0 mb_30 px-0">
                        <h5 class="mb_18">Register</h5>
                        <p class="text_black-2">Sign up for early Sale access plus tailored new arrivals, trends, and
                            promotions. To opt out, click unsubscribe in our emails.</p>
                    </div>
                    <?php
        include("config/db.php");
        $select = "SELECT * FROM role WHERE role_name = 'User'";
        $result = mysqli_query($conn, $select);
        while ($row = mysqli_fetch_array($result)) { ?>

                    <div>
                        <form id="register-form" action="#" method="post" enctype="multipart/form-data"
                            data-mailchimp="true">
                            <?php echo csrf_field(); ?>
                            <div class="tf-field style-1 mb_15">
                                <input class="tf-field-input tf-input" type="hidden" name="user_id"
                                    value="<?php echo $row['role_id']; ?>">
                            </div>
                            <?php } ?>
                            <div class="tf-field style-1 mb_15">
                                <input class="tf-field-input tf-input" type="text" id="property1" name="name"
                                    placeholder=" " required>
                                <label class="tf-field-label fw-4 text_black-2" for="property1">Name</label>
                            </div>
                            <div class="tf-field style-1 mb_15">
                                <input class="tf-field-input tf-input" type="email" id="property2" name="email"
                                    placeholder=" " required>
                                <label class="tf-field-label fw-4 text_black-2" for="property2">Email</label>
                            </div>
                            <div class="tf-field style-1 mb_15">
                                <input class="tf-field-input tf-input" type="password" id="property3" name="password"
                                    placeholder=" " required>
                                <label class="tf-field-label fw-4 text_black-2" for="property3">Password</label>
                            </div>
                            <div class="tf-field style-1 mb_15">
                                <input class="tf-field-input tf-input" type="password" id="property4" name="cpassword"
                                    placeholder=" " required>
                                <label class="tf-field-label fw-4 text_black-2" for="property4">Confirm Password</label>
                            </div>
                            <div class="tf-field style-1 mb_15">
                                <input class="tf-field-input tf-input" type="tel" id="property5" name="number"
                                    placeholder=" " required>
                                <label class="tf-field-label fw-4 text_black-2" for="property5">Phone Number</label>
                            </div>
                            <div class="tf-field style-1 mb_15">
                                <input class="tf-field-input tf-input" type="text" id="property6" name="address"
                                    placeholder=" " required>
                                <label class="tf-field-label fw-4 text_black-2" for="property6">Address</label>
                            </div>
                            <label class="tf-field-label fw-4 text_black-2" for="profilePicture">Profile Picture</label>
                            <div class="tf-field style-1 mb_15">
                                <input class="tf-field-input tf-input" type="file" id="profilePicture"
                                    name="profile_picture" required style="padding-bottom: 40px;">
                            </div>
                            <div class="mb_20">
                                <button type="submit"
                                    class="tf-btn w-100 radius-3 btn-fill animate-hover-btn justify-content-center"
                                    name="submit">Register</button>
                            </div>
                            <div class="text-center">
                                <a href="login.php" class="tf-btn btn-line">Already have an account? Log in here<i
                                        class="icon icon-arrow1-top-left"></i></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
        <?php include('include/footer.php') ?>