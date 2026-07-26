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
                            <h4 class="main-title">About Us</h4>
                        </div>
                    </div>
                    <br>
                    <!-- Breadcrumb end -->

                    <!-- ready to use form start -->
                    <?php 
                                    include('../config/db.php');
                                    if (isset($_POST['submit'])) {
                                      $about_name = $_POST['about_name'];
                                      $about_desc = $_POST['about_desc'];
                                        $imgName = $_FILES['about_image']['name'];
                                        $temping = $_FILES['about_image']['tmp_name'];
                                        $imagePath = "../image/" . $imgName;
                                    
                                        if (move_uploaded_file($temping, $imagePath)) {
                                            $sql = "INSERT INTO `about_us` (about_name, about_desc, about_image) VALUES (?, ?, ?)";
                                            $stmt = mysqli_prepare($conn, $sql);
                                            mysqli_stmt_bind_param($stmt, "sss", $about_name, $about_desc, $imagePath);
                                            $result = mysqli_stmt_execute($stmt);
                                            
                                            if ($result) {
                                                echo "<script>location.replace('show_about.php')</script>";
                                            } else {
                                                echo mysqli_error($conn);
                                            }
                                        } else {
                                            echo "<script>showToast('File upload failed', 'error');</script>";
                                        }
                                    }
                                    ?>



                    <div class="row">
                        <!-- Book Appointment Form start -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Add About Us</h5>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data" class="app-form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">About Us Name</label>
                                                    <input type="text" class="form-control" placeholder=" Name"
                                                        name="about_name" required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">About Us Description</label>
                                                    <input type="text" class="form-control" placeholder="Description"
                                                        name="about_desc" required="">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Add Image</label>
                                                    <input type="file" class="form-control" placeholder="Image"
                                                        name="about_image" required="">
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
                    <i class="ph-bold ph-arrow-up"></i>
                </span>
            </div>
            <?php include('footer.php')?>