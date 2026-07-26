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
                            <h4 class="main-title">Update Slider Form</h4>
                        </div>
                    </div>
                    <br>
                    <!-- Breadcrumb end -->

                    <!-- ready to use form start -->
                    <?php
include('../config/db.php');
$slider_id = $_GET['slider_id'] ?? '';
if (!ctype_digit((string)$slider_id)) { die('Invalid ID.'); }
$sql = "SELECT * FROM slider WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $slider_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while($row=mysqli_fetch_assoc($result)){
?>

                    <div class="row">
                        <!-- Book Appointment Form start -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Update Slider Form</h5>
                                </div>
                                <div class="card-body">
                                    <form action="#" class="app-form" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Update Slider Title</label>
                                                    <input type="text" class="form-control" placeholder="Update Role"
                                                        name="slider_head" required=""
                                                        value="<?php echo $row['title'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Update Slider Description</label>
                                                    <input type="text" class="form-control" placeholder="Update Role"
                                                        name="slider_desc" required=""
                                                        value="<?php echo $row['description'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Previous Image</label>
                                                    <input type="hidden" class="form-control" placeholder="Update Role"
                                                        name="image" required="" value="<?php echo $row['image'] ?>">
                                                    <br>
                                                    <img src="<?php  echo $row['image']?>" width="150px" height="150px">
                                                    <br>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Update Slider Image</label>
                                                    <input type="file" class="form-control" placeholder="Update Role"
                                                        name="slider_image">
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
                    $slider_id = $_GET['slider_id'] ?? '';
                    if (!ctype_digit((string)$slider_id)) { die('Invalid ID.'); }
                    if(isset($_POST['update'])){
                        $slider_head = $_POST['slider_head'];
                        $slider_desc = $_POST['slider_desc'];
                        $slider_image = $_POST['image'];
                        $imgName = $_FILES['slider_image']['name'];
                        $temping = $_FILES['slider_image']['tmp_name'];
                        $imagePath = "../image/" . $imgName;
                        if($imgName == null){
                            $update = "UPDATE `slider` SET `description` = ?, `image` = ? WHERE `slider`.`id` = ?";
                            $stmt = mysqli_prepare($conn, $update);
                            mysqli_stmt_bind_param($stmt, "ssi", $slider_desc, $slider_image, $slider_id);
                            $result = mysqli_stmt_execute($stmt);
                            if($result){
                                echo "<script>location.replace('showslider.php')</script>";
                            }
                        }
                        else{
                    
                        if (move_uploaded_file($temping, $imagePath)) {
                        $update = "UPDATE `slider` SET `title` = ?, `description` = ?, `image` = ? WHERE `slider`.`id` = ?";
                        $stmt = mysqli_prepare($conn, $update);
                        mysqli_stmt_bind_param($stmt, "sssi", $slider_head, $slider_desc, $imagePath, $slider_id);
                        $result = mysqli_stmt_execute($stmt);
                        if($result){
                            echo "<script>location.replace('showslider.php')</script>";
                        }
                        } }
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