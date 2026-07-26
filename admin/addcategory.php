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
                            <h4 class="main-title">Category</h4>
                        </div>
                    </div>
                    <br>
                    <!-- Breadcrumb end -->

                    <!-- form start -->
                    <?php 
                                    include('../config/db.php');
                                    if (isset($_POST['submit'])) {
                                      $category_name = $_POST['category_name'];
                                        $imgName = $_FILES['category_image']['name'];
                                        $temping = $_FILES['category_image']['tmp_name'];
                                        $imagePath = "../image/" . $imgName;
                                    
                                        if (move_uploaded_file($temping, $imagePath)) {
                                            $sql = "INSERT INTO `category` (category_name, category_image) VALUES (?, ?)";
                                            $stmt = mysqli_prepare($conn, $sql);
                                            mysqli_stmt_bind_param($stmt, "ss", $category_name, $imagePath);
                                            $result = mysqli_stmt_execute($stmt);
                                            
                                            if ($result) {
                                                echo "<script>location.replace('showcategory.php')</script>";
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
                                    <h5>Add Category</h5>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data" class="app-form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Add Category</label>
                                                    <input type="text" class="form-control" placeholder="Category Name"
                                                        name="category_name" required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Add Category Image</label>
                                                    <input type="file" class="form-control" placeholder="Category Image"
                                                        name="category_image" required="">
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