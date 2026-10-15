<?php
include 'includes/header.php';
include 'includes/db_con.php';

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

/* Update quantity */
if (isset($_POST['update_qty'])) {
    $cart_id = (int)$_POST['cart_id'];
    $qty     = (int)$_POST['quantity'];

    mysqli_query(
        $conn,
        "UPDATE cart SET quantity='$qty'
         WHERE id='$cart_id' AND user_id='$user_id'"
    );
    header("Location: my_cart.php");
    exit;
}
 
/* Delete item */
if (isset($_GET['delete'])) {
    $cart_id = (int)$_GET['delete'];
    mysqli_query(
        $conn,
        "DELETE FROM cart WHERE id='$cart_id' AND user_id='$user_id'"
    );
     header("Location: my_cart.php");
    exit;
}

/* Fetch cart */
$sql = "
SELECT 
    c.id AS cart_id,
    p.id AS product_id,
    p.name,
    p.price,
    c.size,
    c.quantity,
    (
        SELECT image FROM product_images
        WHERE product_id = p.id
        ORDER BY id ASC LIMIT 1
    ) AS image
FROM cart c
JOIN products p ON c.product_id = p.id
WHERE c.user_id='$user_id'
";
$res = mysqli_query($conn, $sql);

$total = 0;
?>

<section class="py-5">
<div class="container py-5">

<table class="table table-bordered align-middle table-responsive">
<thead class="table-dark">
<tr>
    <th>#</th>
    <th>Image</th>
    <th>Name</th>
    <th>Price</th>
    <th>Size</th>
    <th>Qty</th>
    <th>Subtotal</th>
    <th>Action</th>
</tr>
</thead>
<tbody>

<?php if (mysqli_num_rows($res) == 0) { ?>
<tr><td colspan="8" class="text-center">Cart is empty</td></tr>
<?php } ?>

<?php $i=1; while ($row = mysqli_fetch_assoc($res)) { 
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
?>
<tr>
    <td><?= $i++; ?></td>
    <td><img src="<?= $row['image']; ?>" width="60"></td>
    <td><?= htmlspecialchars($row['name']); ?></td>
    <td>₹<?= $row['price']; ?></td>
    <td><?= $row['size']; ?></td>

    <td>
        <form method="post" class="d-flex">
            <input type="hidden" name="cart_id" value="<?= $row['cart_id']; ?>">
            <input type="number" name="quantity" value="<?= $row['quantity']; ?>"
                   min="1" class="form-control me-2" style="width:80px">
            <button name="update_qty" class="btn btn-success btn-sm">Update</button>
        </form>
    </td>

    <td>₹<?= $subtotal; ?></td>

    <td>
        <a href="my_cart.php?delete=<?= $row['cart_id']; ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Remove item?')">Delete</a>
    </td>
</tr>


<?php } ?>

</tbody>
</table>
<?php
$gst_rate = 5; // %
$gst_amount = ($total * $gst_rate) / 100;
$grand_total = $total + $gst_amount;
?>

<div class="text-end mt-4">
    <p><strong>Subtotal:</strong> ₹<?= number_format($total, 2); ?></p>
    <p><strong>GST (<?= $gst_rate ?>%):</strong> ₹<?= number_format($gst_amount, 2); ?></p>
    <h4><strong>Total Payable:</strong> ₹<?= number_format($grand_total, 2); ?></h4>
<?php if(mysqli_num_rows($res) > 0)
  { ?>
    <a href="checkout.php" disabled class="btn btn-dark mt-2">
        Checkout
    </a>
    <?php
  }else{
    ?>
    <button class="btn btn-secondary" disabled>Checkout</button>
    <?php
  }
?>
</div>

</div>
</section>
<script>
  updateCartBadge();
</script>
<?php include 'includes/footer.php'; ?>
