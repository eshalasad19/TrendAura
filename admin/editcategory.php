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
                            <h4 class="main-title">Update Category</h4>
                        </div>
                    </div>
                    <br>
                    <!-- Breadcrumb end -->

                    <!--form start -->
                    <?php
include('../config/db.php');
$category_id = $_GET['category_id'] ?? '';
if (!ctype_digit((string)$category_id)) { die('Invalid ID.'); }
$sql = "SELECT * FROM category WHERE category_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $category_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while($row=mysqli_fetch_assoc($result)){
?>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Update Category Form</h5>
                                </div>
                                <div class="card-body">
                                    <form action="#" class="app-form" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Update Category</label>
                                                    <input type="text" class="form-control" placeholder="Update Role"
                                                        name="category_name" required=""
                                                        value="<?php echo $row['category_name'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Previous Image</label>
                                                    <br>
                                                    <input type="hidden" class="form-control" placeholder="Update Role"
                                                        name="cat_image"
                                                        value="<?php echo $row['category_image'] ?>">
                                                    <img src="<?php  echo $row['category_image']?>" width="150px"
                                                        height="150px">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Update Category Image</label>
                                                    <input type="file" class="form-control" placeholder="Update Role"
                                                        name="category_image"
                                                        value="<?php echo $row['category_image'] ?>">
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
                    $category_id = $_GET['category_id'] ?? '';
                    if (!ctype_digit((string)$category_id)) { die('Invalid ID.'); }
                    if(isset($_POST['update'])){
                        $category_name = $_POST['category_name'];
                        $cat_image = $_POST['cat_image'];
                        $imgName = $_FILES['category_image']['name'];
                        $temping = $_FILES['category_image']['tmp_name'];
                        $imagePath = "../image/" . $imgName;
                        if($imgName == null){
                            $update = "UPDATE `category` SET `category_name` = ?, `category_image` = ? WHERE `category`.`category_id` = ?";
                            $stmt = mysqli_prepare($conn, $update);
                            mysqli_stmt_bind_param($stmt, "ssi", $category_name, $cat_image, $category_id);
                            $result = mysqli_stmt_execute($stmt);
                            if($result){
                                echo "<script>location.replace('showcategory.php')</script>";
                            }
                        }
                        else{
                    
                        if (move_uploaded_file($temping, $imagePath)) {
                            $update = "UPDATE `category` SET `category_name` = ?, `category_image` = ? WHERE `category`.`category_id` = ?";
                            $stmt = mysqli_prepare($conn, $update);
                            mysqli_stmt_bind_param($stmt, "ssi", $category_name, $imagePath, $category_id);
                            $result = mysqli_stmt_execute($stmt);
                        if($result){
                            echo "<script>location.replace('showcategory.php')</script>";
                        }
                        } }
                    }
                     ?>
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