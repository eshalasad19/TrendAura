<?php   
include('../config/db.php');
$sub_category_id = $_GET['sub_category_id'] ?? '';
if (!ctype_digit((string)$sub_category_id)) {
    die('Invalid ID.');
}
$delete = "DELETE FROM sub_category WHERE sub_id = ?";
$stmt = mysqli_prepare($conn, $delete);
mysqli_stmt_bind_param($stmt, "i", $sub_category_id);
$result = mysqli_stmt_execute($stmt);
if($result){
    echo "<script> location.replace('show_sub_category.php')</script>";
};

?>