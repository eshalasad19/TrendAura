<?php   
include('../config/db.php');
$slider_id = $_GET['slider_id'] ?? '';
if (!ctype_digit((string)$slider_id)) {
    die('Invalid ID.');
}
$delete = "DELETE FROM slider WHERE id = ?";
$stmt = mysqli_prepare($conn, $delete);
mysqli_stmt_bind_param($stmt, "i", $slider_id);
$result = mysqli_stmt_execute($stmt);
if($result){
    echo "<script> location.replace('showslider.php')</script>";
};

?>