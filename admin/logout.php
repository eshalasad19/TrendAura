<?php
session_start();
unset($_SESSION['admin']);  // sirf admin ko logout karo
header("Location: admin_login.php");
exit();
?>
