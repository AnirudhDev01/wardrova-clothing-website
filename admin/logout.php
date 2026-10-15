<?php
session_start();
unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_id']);
unset($_SESSION['admin_role']);
unset($_SESSION['admin_name']);
header('location: index.php');
exit;
?>