<?php
session_start();
include 'includes/db_con.php';

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

$order_id = (int)$_GET['id'];
$user_id  = $_SESSION['user_id'];

/* Check order */
$order_q = mysqli_query(
    $conn,
    "SELECT * FROM orders
     WHERE id='$order_id' AND user_id='$user_id'
     AND status='placed'"
);

if (mysqli_num_rows($order_q) == 0) {
    header("location: orders.php");
    exit;
}

/* Restore stock */
$items_q = mysqli_query(
    $conn,
    "SELECT * FROM order_items WHERE order_id='$order_id'"
);

while ($item = mysqli_fetch_assoc($items_q)) {
    mysqli_query(
        $conn,
        "UPDATE product_sizes
         SET stock = stock + {$item['quantity']}
         WHERE product_id='{$item['product_id']}'
         AND size='{$item['size']}'"
    );
}

/* Update order status */
mysqli_query(
    $conn,
    "UPDATE orders SET status='cancelled' WHERE id='$order_id'"
);

header("location: orders.php");
exit;
