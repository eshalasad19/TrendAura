<?php
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

include('config/db.php');

// Agar user login nahi hai ya role User nahi hai
if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] != 'User') {
    header("Location: login.php");
    exit();
}

// Session se user_id lo
$user_id = $_SESSION['user']['user_id'];

// Database me check karo user exist karta hai ya nahi
$check_user = "SELECT id FROM register WHERE id = ?";
$check_stmt = mysqli_prepare($conn, $check_user);
mysqli_stmt_bind_param($check_stmt, "i", $user_id);
mysqli_stmt_execute($check_stmt);
$result = mysqli_stmt_get_result($check_stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    // ❌ Agar user delete ho gaya → logout + redirect
    session_destroy();
    header("Location: login.php?error=account_deleted");
    exit();
}
?>
