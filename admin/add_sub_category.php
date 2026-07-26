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
                            <h4 class="main-title">Sub-Category</h4>
                        </div>
                    </div>
                    <br>
                    <!-- Breadcrumb end -->

                    <!-- form start -->
                    <?php 
                                    include('../config/db.php');
                                    if (isset($_POST['submit'])) {
                                      $category_name = $_POST['category_name'];
                                      $category_id = $_POST['category_id'];
                                        $imgName = $_FILES['category_image']['name'];
                                        $temping = $_FILES['category_image']['tmp_name'];
                                        $imagePath = "../image/" . $imgName;
                                    
                                        if (move_uploaded_file($temping, $imagePath)) {
                                            $sql = "INSERT INTO `sub_category` (sub_name, sub_image,category_id) VALUES (?, ?, ?)";
                                            $stmt = mysqli_prepare($conn, $sql);
                                            mysqli_stmt_bind_param($stmt, "ssi", $category_name, $imagePath, $category_id);
                                            $result = mysqli_stmt_execute($stmt);
                                            
                                            if ($result) {
                                                echo "<script>location.replace('show_sub_category.php')</script>";
                                            } else {
                                                echo mysqli_error($conn);
                                            }
                                        } else {
                                            echo "<script>showToast('File upload failed', 'error');</script>";
                                        }
                                    }
                                    ?>



                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Add Sub-Category</h5>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data" class="app-form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Add Sub-Category</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Sub-Category Name" name="category_name"
                                                        required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Add Sub-Category Image</label>
                                                    <input type="file" class="form-control"
                                                        placeholder="Sub-Category Image" name="category_image"
                                                        required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="category_id">Choose a
                                                        Category:</label>

                                                    <select name="category_id" id="category_id" class="form-control">
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