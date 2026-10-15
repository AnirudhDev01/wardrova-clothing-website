<?php
include '../includes/db_con.php';
include 'includes/header.php';
if(!isset($_SESSION['admin_logged_in'])){
    header('location: index.php');
    exit;
}
$order_id = (int)$_GET['id'];

/* Update status */
if (isset($_POST['update_status'])) {
    $status = $_POST['status'];

    mysqli_query(
        $conn,
        "UPDATE orders SET status='$status' WHERE id='$order_id'"
    );

    header("location: order_details.php?id=$order_id");
    exit;
}

/* Order info */
$order_q = mysqli_query(
    $conn,
    "SELECT o.*, u.fname, u.email
     FROM orders o
     JOIN users u ON o.user_id = u.id
     WHERE o.id='$order_id'"
);
$order = mysqli_fetch_assoc($order_q);

/* Order items */
$items_q = mysqli_query(
    $conn,
    "SELECT oi.*, p.name
     FROM order_items oi
     JOIN products p ON oi.product_id = p.id
     WHERE oi.order_id='$order_id'"
);
?>

<div class="container py-5">
<h3 class="mt-3">Order #<?= $order_id; ?></h3>

<p><strong>User:</strong> <?= htmlspecialchars($order['fname']); ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($order['email']); ?></p>
<p><strong>Subtotal:</strong> ₹<?= $order['total_amount']; ?></p>
<p><strong>GST:</strong> ₹<?= $order['gst_amount']; ?></p>
<p><strong>Grand Total:</strong> ₹<?= $order['grand_total']; ?></p>

<form method="post" class="mb-4">
<label>Order Status</label>
<select name="status" class="form-select w-25">
    <?php foreach (['placed','shipped','delivered','cancelled'] as $s) { ?>
        <option value="<?= $s; ?>" <?= ($order['status']==$s)?'selected':''; ?>>
            <?= ucfirst($s); ?>
        </option>
    <?php } ?>
</select>
<button name="update_status" class="btn btn-dark mt-2">Update Status</button>
</form>

<table class="table table-bordered">
<thead class="table-dark">
<tr>
    <th>Product</th>
    <th>Size</th>
    <th>Quantity</th>
    <th>Price</th>
</tr>
</thead>
<tbody>

<?php while ($item = mysqli_fetch_assoc($items_q)) { ?>
<tr>
    <td><?= htmlspecialchars($item['name']); ?></td>
    <td><?= $item['size']; ?></td>
    <td><?= $item['quantity']; ?></td>
    <td>₹<?= $item['price']; ?></td>
</tr>
<?php } ?>

</tbody>
</table>

</div>

<?php include 'includes/footer.php'; ?>
