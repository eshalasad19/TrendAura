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
                            <h4 class="main-title">Product</h4>
                        </div>
                    </div>
                    <br>
                    <!-- Breadcrumb end -->

                    <!-- ready to use form start -->
                    <?php 
                                    include('../config/db.php');
                                    if (isset($_POST['submit'])) {
                                      $product_name = $_POST['product_name'];
                                      $product_description = $_POST['product_description'];
                                      $product_price = $_POST['product_price'];
                                      $product_stock = $_POST['product_stock'];
                                      $category_id = $_POST['category_id'];
                                      $sub_category_id = $_POST['sub_category_id'];
                                        $imgName = $_FILES['product_image']['name'];
                                        $temping = $_FILES['product_image']['tmp_name'];
                                        $imagePath = "../image/" . $imgName;
                                    
                                        if (move_uploaded_file($temping, $imagePath)) {
                                            $sql = "INSERT INTO `product` (product_name, product_image, product_price, product_desc, stock, cat_id, sub_cat_id ) VALUES (?, ?, ?, ?, ?, ?, ?)";
                                            $stmt = mysqli_prepare($conn, $sql);
                                            mysqli_stmt_bind_param($stmt, "ssdsdii", $product_name, $imagePath, $product_price, $product_description, $product_stock, $category_id, $sub_category_id);
                                            $result = mysqli_stmt_execute($stmt);
                                            
                                            if ($result) {
                                                echo "<script>location.replace('showproduct.php')</script>";
                                            } else {
                                                echo mysqli_error($conn);
                                            }
                                        } else {
                                             echo "<script>adminToast('File upload failed', 'error');</script>";
                                        }
                                    }
                                    ?>



                    <div class="row">
                        <!-- Book Appointment Form start -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Add Product</h5>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data" class="app-form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Add Product Name</label>
                                                    <input type="text" class="form-control" placeholder="Product Name"
                                                        name="product_name" required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Add Product Description</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Product Description" name="product_description"
                                                        required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Add Product Image</label>
                                                    <input type="file" class="form-control" placeholder="Product Image"
                                                        name="product_image" required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Add Product Price</label>
                                                    <input type="number" class="form-control"
                                                        placeholder="Product Price" name="product_price" required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Stock</label>
                                                    <input type="number" class="form-control"
                                                        placeholder="Product Stock" name="product_stock" required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="category_id">Choose a
                                                        Category:</label>

                                                    <select name="category_id" id="category_id"
                                                        class="form-control">
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
                                                    <label class="form-label" for="sub_category_id">Choose a
                                                        Sub-Category:</label>

                                                    <select name="sub_category_id" id="sub_category_id"
                                                        class="form-control">
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
                                            <div class="col-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary"
                                                        name="submit">Submit</button>
                                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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