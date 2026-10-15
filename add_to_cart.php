<?php
session_start();
include 'includes/db_con.php';

/* User must be logged in */
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

$user_id    = $_SESSION['user_id'];
$product_id = (int)$_POST['product_id'];
$size       = mysqli_real_escape_string($conn, $_POST['size']);
$quantity   = (int)$_POST['quantity'];

/* Basic validation */
if ($product_id <= 0 || $quantity <= 0 || empty($size)) {
    header("location: products.php");
    exit;
}

/* Check if same product + same size already in cart */
$check_q = mysqli_query(
    $conn,
    "SELECT id, quantity 
     FROM cart 
     WHERE user_id='$user_id' 
     AND product_id='$product_id' 
     AND size='$size'"
);

if (mysqli_num_rows($check_q) > 0) {
    /* Update quantity */
    mysqli_query(
        $conn,
        "UPDATE cart
         SET quantity = quantity + $quantity
         WHERE user_id='$user_id'
         AND product_id='$product_id'
         AND size='$size'"
    );
} else {
    /* Insert new cart item */
    mysqli_query(
        $conn,
        "INSERT INTO cart (user_id, product_id, size, quantity)
         VALUES ('$user_id', '$product_id', '$size', '$quantity')"
    );
}


$redirect = $_SERVER['HTTP_REFERER'] ?? 'products.php';
header("Location: $redirect");
exit;
