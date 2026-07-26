<?php   
include('../config/db.php');
$product_id = $_GET['product_id'] ?? '';
if (!ctype_digit((string)$product_id)) {
    die('Invalid ID.');
}
$delete = "DELETE FROM product WHERE product_id = ?";
$stmt = mysqli_prepare($conn, $delete);
mysqli_stmt_bind_param($stmt, "i", $product_id);
$result = mysqli_stmt_execute($stmt);
if($result){
    echo "<script> location.replace('showproduct.php')</script>";
};

?>