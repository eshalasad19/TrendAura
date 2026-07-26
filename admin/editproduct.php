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
                            <h4 class="main-title">Update Product Form</h4>
                        </div>
                    </div>
                    <br>
                    <!-- Breadcrumb end -->

                    <!-- ready to use form start -->
                    <?php
include('../config/db.php');
$product_id = $_GET['product_id'] ?? '';
if (!ctype_digit((string)$product_id)) { die('Invalid ID.'); }
$sql = "SELECT * FROM product WHERE product_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while($row=mysqli_fetch_assoc($result)){
?>

                    <div class="row">
                        <!-- Book Appointment Form start -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Update Product Form</h5>
                                </div>
                                <div class="card-body">
                                    <form action="#" class="app-form" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Update Product Name</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Update Product Name" name="product_name"
                                                        required="" value="<?php echo $row['product_name'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Update Product Description</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Update Product Description"
                                                        name="product_description" required=""
                                                        value="<?php echo $row['product_desc'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Previous Product Image</label>
                                                    <br>
                                                    <input type="hidden" class="form-control"
                                                        placeholder="Update Product Image" name="pro_image"
                                                        value="<?php echo $row['product_image'] ?>">
                                                    <img src="<?php echo $row['product_image'] ?>" width="100"
                                                        height="100">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Update Product Image</label>
                                                    <input type="file" class="form-control"
                                                        placeholder="Update Product Image" name="product_image"
                                                        value="<?php echo $row['product_image'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Update Product Price</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Update Product Price" name="product_price"
                                                        required="" value="<?php echo $row['product_price'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Update Product Stock</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Update Product Stock" name="product_stock"
                                                        required="" value="<?php echo $row['stock'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Update Product Category</label>
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
                                                <div class="mb-3">
                                                    <label class="form-label">Update Product Sub-Category</label>
                                                    <select name="sub_category" id="sub_category" class="form-control">
                                                        <?php
                                                        include('../config/db.php');
                                                        $sql = "SELECT * FROM sub_category";
                                                        $result = mysqli_query($conn, $sql);
                                                        while ($row =  mysqli_fetch_array($result)) {


                                                        ?>
                                                        <option value="<?php echo $row['sub_id'] ?>">
                                                            <?php echo $row['sub_name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="col-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary"
                                                        name="update">Update</button>
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
                    $product_id = $_GET['product_id'] ?? '';
                    if (!ctype_digit((string)$product_id)) { die('Invalid ID.'); }
                    if(isset($_POST['update'])){
                        $product_name = $_POST['product_name'];
                        $product_desc = $_POST['product_description'];
                        $product_price = $_POST['product_price'];
                        $product_stock = $_POST['product_stock'];
                        $pro_image = $_POST['pro_image'];
                        $category =  $_POST['category'];
                        $sub_category =  $_POST['sub_category'];
                        $imgName = $_FILES['product_image']['name'];
                        $temping = $_FILES['product_image']['tmp_name'];
                        $imagePath = "../image/" . $imgName;
                        if($imgName == null){
                            $sql = "UPDATE product SET product_name = ?, product_desc = ?, product_image = ?, product_price = ?, stock = ?, cat_id = ?, sub_cat_id = ? WHERE product_id = ?";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, "sssdiiii", $product_name, $product_desc, $pro_image, $product_price, $product_stock, $category, $sub_category, $product_id);
                            $result = mysqli_stmt_execute($stmt);
                            if($result){
                                echo "<script>location.replace('showproduct.php')</script>";
                            }
                        }
                        else{
                    
                        if (move_uploaded_file($temping, $imagePath)) {
                            $sql = "UPDATE product SET product_name = ?, product_desc = ?, product_image = ?, product_price = ?, stock = ?, cat_id = ?, sub_cat_id = ? WHERE product_id = ?";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, "sssdiiii", $product_name, $product_desc, $imagePath, $product_price, $product_stock, $category, $sub_category, $product_id);
                            $result = mysqli_stmt_execute($stmt);
                        if($result){
                            echo "<script>location.replace('showproduct.php')</script>";
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
                    <i class="ti ti-arrow-up"></i>
                </span>
            </div>
            <?php include('footer.php')?>