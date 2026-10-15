<?php
include 'includes/header.php';
include 'includes/db_con.php';

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}
?>

<section class="py-5">
<div class="container">
<h3 class="mb-4">Billing Details</h3>
<?php
$cart_q = mysqli_query(
    $conn,
    "SELECT c.quantity, p.price
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id='{$_SESSION['user_id']}'"
);
$subtotal = 0;
while ($row = mysqli_fetch_assoc($cart_q)) {
    $subtotal += $row['price'] * $row['quantity'];
}

$gst_rate = 5;
$gst_amount = ($subtotal * $gst_rate) / 100;
$grand_total = $subtotal + $gst_amount;
?>
<form method="post" action="place_order.php">
<div class="alert alert-info">
    <p>Subtotal: ₹<?= number_format($subtotal,2); ?></p>
    <p>GST (<?= $gst_rate ?>%): ₹<?= number_format($gst_amount,2); ?></p>
    <h5>Total Payable: ₹<?= number_format($grand_total,2); ?></h5>
</div>
    <div class="mb-3">
        <label>Full Name</label>
        <input type="text" name="full_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Card Number</label>
        <input type="text"
               name="card_number"
               class="form-control"
               maxlength="16"
               placeholder="1234 5678 9012 3456"
               required>
        <small class="text-muted">Only last 4 digits will be stored</small>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Expiry Month</label>
            <input type="text" name="expiry_month" class="form-control" placeholder="MM" required>
        </div>

        <div class="col-md-4 mb-3">
            <label>Expiry Year</label>
            <input type="text" name="expiry_year" class="form-control" placeholder="YYYY" required>
        </div>

        <div class="col-md-4 mb-3">
            <label>CVV</label>
            <input type="password" class="form-control" placeholder="***" required>
            <small class="text-danger">CVV is NOT stored</small>
        </div>
    </div>

    <div class="mb-3">
        <label>Billing Address</label>
        <textarea name="billing_address" class="form-control" required></textarea>
    </div>

    <button type="submit" class="btn btn-dark">
        Place Order
    </button>

</form>
</div>
</section>

<?php include 'includes/footer.php'; ?>
