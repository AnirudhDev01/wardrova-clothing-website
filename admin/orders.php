<?php
include '../includes/db_con.php';
include 'includes/header.php';

if(!isset($_SESSION['admin_logged_in'])){
    header('location: index.php');
    exit;
}

$orders_q = mysqli_query(
    $conn,
    "SELECT 
        o.id,
        o.total_amount,
        o.status,
        o.created_at,
        u.fname,
        u.email
     FROM orders o
     JOIN users u ON o.user_id = u.id
     ORDER BY o.id DESC"
);
?>

<div class="container py-5">
<h3 class="my-4">Orders</h3>

<table class="table table-bordered table-hover">
<thead class="table-dark">
<tr>
    <th>Order ID</th>
    <th>User</th>
    <th>Email</th>
    <th>Total</th>
    <th>Status</th>
    <th>Date</th>
    <th>Action</th>
</tr>
</thead>
<tbody>

<?php while ($order = mysqli_fetch_assoc($orders_q)) { ?>
<tr>
    <td>#<?= $order['id']; ?></td>
    <td><?= htmlspecialchars($order['fname']); ?></td>
    <td><?= htmlspecialchars($order['email']); ?></td>
    <td>₹<?= $order['total_amount']; ?></td>
    <td>
        <span class="badge bg-info text-dark">
            <?= strtoupper($order['status']); ?>
        </span>
    </td>
    <td><?= date('d M Y', strtotime($order['created_at'])); ?></td>
    <td>
        <a href="order_details.php?id=<?= $order['id']; ?>"
           class="btn btn-sm btn-primary">
           View Details
        </a>
    </td>
</tr>
<?php } ?>

</tbody>
</table>
</div>

<?php include 'includes/footer.php'; ?>
