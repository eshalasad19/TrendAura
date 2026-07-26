<?php
session_start();
unset($_SESSION['user']);  // sirf user ko logout karo
header("Location: login.php");
exit();
?>
