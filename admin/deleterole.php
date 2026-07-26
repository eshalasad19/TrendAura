<?php   
include('../config/db.php');
$role_id = $_GET['role_id'] ?? '';
if (!ctype_digit((string)$role_id)) {
    die('Invalid ID.');
}
$delete = "DELETE FROM role WHERE role_id = ?";
$stmt = mysqli_prepare($conn, $delete);
mysqli_stmt_bind_param($stmt, "i", $role_id);
$result = mysqli_stmt_execute($stmt);
if($result){
    echo "<script> location.replace('showrole.php')</script>";
};

?>