<?php   
include('../config/db.php');
$category_id = $_GET['category_id'] ?? '';
if (!ctype_digit((string)$category_id)) {
    die('Invalid ID.');
}
$delete = "DELETE FROM category WHERE category_id = ?";
$stmt = mysqli_prepare($conn, $delete);
mysqli_stmt_bind_param($stmt, "i", $category_id);
$result = mysqli_stmt_execute($stmt);
if($result){
    echo "<script> location.replace('showcategory.php')</script>";
};

?>