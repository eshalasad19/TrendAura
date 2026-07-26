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
                            <h4 class="main-title">Update Category Form</h4>
                        </div>
                    </div>
                    <br>
                    <!-- Breadcrumb end -->

                    <!-- ready to use form start -->
                    <?php
include('../config/db.php');
$about_id = $_GET['about_id'] ?? '';
if (!ctype_digit((string)$about_id)) { die('Invalid ID.'); }
$sql = "SELECT * FROM about_us WHERE about_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $about_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while($row=mysqli_fetch_assoc($result)){
?>

                    <div class="row">
                        <!-- Book Appointment Form start -->
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
                                                    <label class="form-label">Update Name</label>
                                                    <input type="text" class="form-control" placeholder="Update Name"
                                                        name="about_name" required=""
                                                        value="<?php echo $row['about_name'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Update Description</label>
                                                    <input type="text" class="form-control" placeholder="Update Description"
                                                        name="about_desc" required=""
                                                        value="<?php echo $row['about_desc'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Previous Image</label>
                                                    <br>
                                                    <input type="hidden" class="form-control" placeholder="Previous Image"
                                                        name="ab_image"
                                                        value="<?php echo $row['about_image'] ?>">
                                                    <img src="<?php  echo $row['about_image']?>" width="150px"
                                                        height="150px">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Update Image</label>
                                                    <input type="file" class="form-control" placeholder="New Image"
                                                        name="about_image"
                                                        value="<?php echo $row['about_image'] ?>">
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
$about_id = $_GET['about_id'] ?? '';
if (!ctype_digit((string)$about_id)) { die('Invalid ID.'); }

if (isset($_POST['update'])) {
    $about_name = $_POST['about_name'];
    $about_desc = $_POST['about_desc'];
    $about_image = $_POST['ab_image']; // Default to existing image
    $imgName = $_FILES['about_image']['name'];
    $temping = $_FILES['about_image']['tmp_name'];

    // Check if a new image is uploaded
    if (!empty($imgName)) {
        $imagePath = "../image/" . $imgName;
        if (move_uploaded_file($temping, $imagePath)) {
            $about_image = $imagePath; // Update to new image path
        } else {
            echo "<script>adminToast('Failed to upload new image.', 'error');</script>";
        }
    }

    // Update query
    $update = "UPDATE `about_us` SET `about_name` = ?, `about_desc` = ?, `about_image` = ? WHERE `about_us`.`about_id` = ?";
    $stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($stmt, "sssi", $about_name, $about_desc, $about_image, $about_id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "<script>location.replace('show_about.php')</script>";
    } else {
        echo "<script>adminToast('Error: " . mysqli_error($conn) . "', 'error');</script>";
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