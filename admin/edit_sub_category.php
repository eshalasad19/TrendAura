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
                            <h4 class="main-title">Update Sub-Category Form</h4>
                        </div>
                    </div>
                    <br>
                    <!-- Breadcrumb end -->

                    <!-- ready to use form start -->
                    <?php
include('../config/db.php');
$sub_category_id = $_GET['sub_category_id'] ?? '';
if (!ctype_digit((string)$sub_category_id)) { die('Invalid ID.'); }
$sql = "SELECT * FROM sub_category WHERE sub_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $sub_category_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while($row=mysqli_fetch_assoc($result)){
?>

                    <div class="row">
                        <!-- Book Appointment Form start -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Update Sub-Category Form</h5>
                                </div>
                                <div class="card-body">
                                    <form action="#" class="app-form" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Update Sub-Category</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Update Sub-Category" name="category_name"
                                                        required="" value="<?php echo $row['sub_name'] ?>">
                                                </div>
                                                <div class="mb-3">

                                                    <label class="form-label">Previous Image</label>
                                                    <br>
                                                    <input type="hidden" class="form-control"
                                                        placeholder="Update Sub-Category" name="cat_image"
                                                        value="<?php echo $row['sub_image'] ?>">
                                                    <img src="<?php  echo $row['sub_image']?>" width="150px"
                                                        height="150px">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Update Image</label>
                                                    <input type="file" class="form-control"
                                                        placeholder="Update Sub-Category" name="category_image"
                                                        value="<?php echo $row['sub_image'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <select name="category" id="category" class="form-control">
                                                        <?php
                                                        include('../config/db.php');
                                                        $sql = "SELECT * FROM category";
                                                        $result = mysqli_query($conn, $sql);
                                                        while ($row =  mysqli_fetch_array($result)) {


                                                        ?>
                                                        <option value="<?php echo $row['category_id'] ?>">
                                                            <?php echo $row['category_name'] ?></option>
                                                        <?php } ?>
                                                    </select>
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
                    $sub_category_id = $_GET['sub_category_id'] ?? '';
                    if (!ctype_digit((string)$sub_category_id)) { die('Invalid ID.'); }
                    if(isset($_POST['update'])){
                        $sub_category_name = $_POST['category_name'];
                        $sub_cat_image = $_POST['cat_image'];
                        $category =  $_POST['category'];
                        $imgName = $_FILES['category_image']['name'];
                        $temping = $_FILES['category_image']['tmp_name'];
                        $imagePath = "../image/" . $imgName;
                        if($imgName == null){
                            $sql = "UPDATE sub_category SET sub_name = ?, sub_image = ?, category_id = ? WHERE sub_id = ?";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, "ssii", $sub_category_name, $sub_cat_image, $category, $sub_category_id);
                            $result = mysqli_stmt_execute($stmt);
                            if($result){
                                echo "<script>location.replace('show_sub_category.php')</script>";
                            }
                        }
                        else{
                    
                        if (move_uploaded_file($temping, $imagePath)) {
                            $sql = "UPDATE sub_category SET sub_name = ?, sub_image = ?, category_id = ? WHERE sub_id = ?";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, "ssii", $sub_category_name, $imagePath, $category, $sub_category_id);
                            $result = mysqli_stmt_execute($stmt);
                        if($result){
                            echo "<script>location.replace('show_sub_category.php')</script>";
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