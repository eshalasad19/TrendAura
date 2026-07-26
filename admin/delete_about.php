<?php   
include('../config/db.php');
$about_id = $_GET['about_id'] ?? '';
if (!ctype_digit((string)$about_id)) {
    die('Invalid ID.');
}
$delete = "DELETE FROM about_us WHERE about_id = ?";
$stmt = mysqli_prepare($conn, $delete);
mysqli_stmt_bind_param($stmt, "i", $about_id);
$result = mysqli_stmt_execute($stmt);
if($result){
    echo "<script> location.replace('show_about.php')</script>";
};

?>