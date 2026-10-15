<?php include 'includes/header.php'; 
if(!isset($_SESSION['user_id'])){
    header('location: login.php');
    exit;
}
?>

<section class="py-5 text-center">
<div class="container py-5">
    <div class="row d-flex align-items-center" style="height: 60vh;">
        <div class="col-12">
<h2>Order Placed Successfully 🎉</h2>
    <a href="products.php" class="cust_btn mt-3">Continue Shopping</a>
    <a href="orders.php" class="cust_btn mt-3">My Orders</a>
        </div>
    </div>
    
</div>
</section>
<?php include 'includes/footer.php'; ?>