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
                            <h4 class="main-title">Update Role</h4>
                        </div>
                    </div>
                    <br>
                    <!-- Breadcrumb end -->

                    <!-- ready to use form start -->
                    <?php
include('../config/db.php');
$role_id = $_GET['role_id'] ?? '';
if (!ctype_digit((string)$role_id)) { die('Invalid ID.'); }
$sql = "SELECT * FROM role WHERE role_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $role_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while($row=mysqli_fetch_assoc($result)){
?>

                    <div class="row">
                        <!-- Book Appointment Form start -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Update Role Form</h5>
                                </div>
                                <div class="card-body">
                                    <form action="" class="app-form" method="post">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Update Role</label>
                                                    <input type="text" class="form-control" placeholder="Update Role"
                                                        name="role_name" required=""
                                                        value="<?php echo $row['role_name'] ?>">
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="col-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary"
                                                        name="update">Submit</button>
                                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php 
                    include('../config/db.php');
                    if(isset($_POST['update'])){
                        $role_name = $_POST['role_name'];
                        $sql = "UPDATE role SET role_name = ? WHERE role_id = ?";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "si", $role_name, $role_id);
                        $result = mysqli_stmt_execute($stmt);
                        if($result){
                            echo "<script>adminToast('Role updated successfully', 'success'); setTimeout(function(){ location.replace('showrole.php'); }, 1200);</script>";
                        }
                        else{
                            mysqli_error($conn);
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