<?php
include 'includes/header.php';
include 'includes/db_con.php';

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$orders_q = mysqli_query(
    $conn,
    "SELECT * FROM orders
     WHERE user_id='$user_id'
     ORDER BY id DESC"
);
?>

<section class="py-5">
<div class="container py-5">
<h3 class="mb-4">My Orders</h3>

<?php if (mysqli_num_rows($orders_q) == 0) { ?>
    <p>No orders yet.</p>
<?php } ?>

<?php while ($order = mysqli_fetch_assoc($orders_q)) { ?>
<div class="card mb-4">
<div class="card-header d-flex justify-content-between">
    <strong>Order #<?= $order['id']; ?></strong>
    <span class="badge bg-info text-dark text-uppercase">
        <?= $order['status']; ?>
    </span>
</div>

<div class="card-body">
    <p>Subtotal: ₹<?= $order['total_amount']; ?></p>
<p>GST: ₹<?= $order['gst_amount']; ?></p>
<p><strong>Total Paid: ₹<?= $order['grand_total']; ?></strong></p>
    <p>Date: <?= $order['created_at']; ?></p>

    <table class="table table-sm">
        <thead>
            <tr>
                <th>Product</th>
                <th>Size</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $items_q = mysqli_query(
            $conn,
            "SELECT oi.*, p.name
             FROM order_items oi
             JOIN products p ON oi.product_id = p.id
             WHERE oi.order_id='{$order['id']}'"
        );
        while ($item = mysqli_fetch_assoc($items_q)) {
        ?>
            <tr>
                <td><?= htmlspecialchars($item['name']); ?></td>
                <td><?= $item['size']; ?></td>
                <td><?= $item['quantity']; ?></td>
                <td>₹<?= $item['price']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <?php if ($order['status'] === 'placed') { ?>
        <a href="cancel_order.php?id=<?= $order['id']; ?>"
           onclick="return confirm('Cancel this order?')"
           class="btn btn-danger btn-sm">
           Cancel Order
        </a>
    <?php } ?>
</div>
</div>
<?php } ?>

</div>
</section>

<?php include 'includes/footer.php'; ?>
