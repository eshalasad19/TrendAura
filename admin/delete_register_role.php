<?php   
include('../config/db.php');
$id = $_GET['id'] ?? '';
if (!ctype_digit((string)$id)) {
    die('Invalid ID.');
}
$delete = "DELETE FROM register WHERE id = ?";
$stmt = mysqli_prepare($conn, $delete);
mysqli_stmt_bind_param($stmt, "i", $id);
$result = mysqli_stmt_execute($stmt);
if($result){
    echo "<script> location.replace('show_register_role.php')</script>";
};

?>