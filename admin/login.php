<?php include('header.php'); ?>
<?php
session_start();
include('../config/db.php');
require_once('../config/csrf.php');

if (isset($_POST['login'])) {
  require_csrf();
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $sql = "SELECT register.*, role.role_name 
            FROM register 
            JOIN role ON register.role_id = role.role_id 
            WHERE register.email = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {
      if ($row['role_name'] == 'Admin' || $row['role_name'] == 'Product Manager' || $row['role_name'] == 'Order Dispatcher') {
        // Session for admin panel
        session_regenerate_id(true);
        $_SESSION['admin'] = [
          'user_id' => $row['id'],
          'username' => $row['name'],
          'role_name' => $row['role_name'],
          'profile_pic' => $row['profile_pic'],
        ];

        // Redirect to admin dashboard
        header("Location: home.php");
        exit();
      } else {
        echo "<script>adminToast('Access denied. Only Admin, Product Manager, and Order Dispatcher can log in.', 'error');</script>";
      }
    } else {
      echo "<script>adminToast('Invalid password.', 'error');</script>";
    }
  } else {
   echo "<script>adminToast('User not found.', 'error');</script>";
  }
}
?>


<body class="sign-in-bg">
  <div class="app-wrapper d-block">
    <div class="main-container">
      <div class="container">
        <div class="row sign-in-content-bg">
          <div class="col-lg-6 image-contentbox d-none d-lg-block">
            <div class="form-container ">
              <div class="signup-content mt-4">
                <span>
                  <img src="../assets/images/logo/logo.png" alt="" class="img-fluid ">
                </span>
              </div>
              <div class="signup-bg-img">
                <img src="../assets/images/login/04.png" alt="" class="img-fluid">
              </div>
            </div>
          </div>
          <div class="col-lg-6 form-contentbox">
            <div class="form-container">
              <form action="" class="app-form" method="post">
                <?php echo csrf_field(); ?>
                <div class="row">
                  <div class="col-12">
                    <div class="mb-5 text-center text-lg-start">
                      <h2 class="text-primary f-w-600">Welcome To RA-ADMIN!</h2>
                      <p>Sign in with your data that you entered during your registration</p>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control" placeholder="Enter Your Email" id="email" name="email" required>
                    </div>
                    <div class="col-12">
                      <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="Enter Your Password" id="password" name="password" required>
                      </div>
                    </div>
                    <!-- <div class="col-12">
                    <div class="form-check mb-3">
                      <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                      <label class="form-check-label text-secondary" for="checkDefault">
                        Remember me
                      </label>
                    </div>
                  </div> -->
                    <div class="col-12">
                      <div class="mb-3">
                        <!-- Change the anchor tag to a button -->
                        <button type="submit" class="btn btn-primary w-100" name="login">Sign In</button>
                      </div>
                    </div>
                    <!-- <div class="app-divider-v justify-content-center">
                    <p>Or sign in with</p>
                  </div>
                  <div class="col-12">
                    <div class="text-center">
                      <button type="button" class="btn btn-facebook icon-btn b-r-22 m-1"><i class="ti ti-brand-facebook text-white"></i></button>
                      <button type="button" class="btn btn-gmail icon-btn b-r-22 m-1"><i class="ti ti-brand-google text-white"></i></button>
                      <button type="button" class="btn btn-github icon-btn b-r-22 m-1"><i class="ti ti-brand-github text-white"></i></button>
                    </div>
                  </div> -->
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Latest jQuery -->
  <script src="../assets/js/jquery-3.6.3.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>