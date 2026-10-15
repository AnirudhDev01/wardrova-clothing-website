<?php
session_start();
include 'includes/db_con.php';

$user_id = $_SESSION['user_id'];

$full_name = $_POST['full_name'];
$card_last4 = substr($_POST['card_number'], -4);
$expiry_month = $_POST['expiry_month'];
$expiry_year = $_POST['expiry_year'];
$billing_address = $_POST['billing_address'];

$cart_q = mysqli_query(
    $conn,
    "SELECT c.*, p.price
     FROM cart c
     JOIN products p ON c.product_id=p.id
     WHERE c.user_id='$user_id'"
);

$subtotal = 0;
$items = [];

while ($row = mysqli_fetch_assoc($cart_q)) {

    $stock_q = mysqli_query(
        $conn,
        "SELECT stock FROM product_sizes
         WHERE product_id='{$row['product_id']}'
         AND size='{$row['size']}'"
    );
    $stock = mysqli_fetch_assoc($stock_q)['stock'];

    if ($stock < $row['quantity']) {
        die("Insufficient stock");
    }

    $subtotal += $row['price'] * $row['quantity'];
    $items[] = $row;
}

$gst = $subtotal * 0.05;
$grand = $subtotal + $gst;

/* Order */
mysqli_query(
    $conn,
    "INSERT INTO orders (user_id,total_amount,gst_amount,grand_total)
     VALUES ('$user_id','$subtotal','$gst','$grand')"
);
$order_id = mysqli_insert_id($conn);

/* Billing */
mysqli_query(
    $conn,
    "INSERT INTO billing_details
     (order_id,full_name,card_last4,expiry_month,expiry_year,billing_address)
     VALUES ('$order_id','$full_name','$card_last4','$expiry_month','$expiry_year','$billing_address')"
);

/* Items + stock */
foreach ($items as $i) {
    mysqli_query(
        $conn,
        "INSERT INTO order_items
         (order_id,product_id,size,quantity,price)
         VALUES ('$order_id','{$i['product_id']}','{$i['size']}','{$i['quantity']}','{$i['price']}')"
    );

    mysqli_query(
        $conn,
        "UPDATE product_sizes
         SET stock = stock - {$i['quantity']}
         WHERE product_id='{$i['product_id']}'
         AND size='{$i['size']}'"
    );
}

mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");

header("location: order_success.php");
exit;
