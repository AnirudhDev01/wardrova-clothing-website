<?php include 'includes/header.php';
include 'includes/db_con.php';
if (!isset($_GET['id'])) {
    header('location: index.php');
    exit;
}
$product_id = $_GET['id'];
$prod_q = "SELECT p.*, c.name as category FROM products p JOIN categories c ON p.category_id=c.id WHERE p.id=$product_id";
$prod_res = mysqli_query($conn, $prod_q);
if (mysqli_num_rows($prod_res) == 0) {
    echo "<h3 class='text-center py-5'>No Product Found!</h3>";
    include 'includes/footer.php';
    exit;
}
$product = mysqli_fetch_assoc($prod_res);
$images = [];
$img_q = "SELECT image FROM `product_images` WHERE product_id=$product_id";
$img_res = mysqli_query($conn, $img_q);
while ($img = mysqli_fetch_assoc($img_res)) {
    $images[] = $img['image'];
}
$size_q = "SELECT size FROM product_sizes 
           WHERE product_id=$product_id AND stock > 0";

$size_res = mysqli_query($conn, $size_q);

?>

<!-- Main Content -->
<!-- Main Content-->
<section class="py-5">
    <div class="container py-5">
        <div class="row">

            <!-- IMAGE SECTION -->
            <div class="col-lg-6">
                <div class="d-flex align-items-start flex-column-reverse">

                    <!-- Thumbnails -->
                    <div class="me-3">
                        <?php foreach ($images as $img) { ?>
                            <img src="<?php echo $img; ?>" class="thumb-img mb-2"
                                onclick="changeImage('<?php echo $img; ?>')">
                        <?php } ?>
                    </div>

                    <!-- Main Image -->
                    <div class="border p-2 mb-3">
                        <img id="mainImage" src="<?= $images[0] ?? 'images/no-image.png'; ?>" class="main-img">
                    </div>

                </div>
            </div>

            <!-- PRODUCT DETAILS -->
            <div class="col-lg-6 d-flex justify-content-center align-items-start flex-column">
                <h3><?= htmlspecialchars($product['name']); ?></h3>
                <h5 class="text-success">₹<?= $product['price']; ?></h5>

                <p><?= nl2br(htmlspecialchars($product['description'])); ?></p>
                <form method="post" action="add_to_cart.php" class="d-inline">
                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                    <div class="mb-3 w-100">
                        <div class="row">
                            <div class="col-6">
                                <label>Size</label>
                                <select name="size" class="form-select" required>
                                    <?php while ($s = mysqli_fetch_assoc($size_res)) { ?>
                                        <option value="<?= $s['size']; ?>">
                                            <?= $s['size']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-6">
                                <label>Quantity</label>
                                <input type="number" name="quantity" value="1" min="1" class="form-control">
                            </div>
                        </div>
                    </div>
                    <?php if(isset($_SESSION['user_id'])){
                        ?>
                    <button type="submit" class="add_cart_btn">
                        Add to Cart
                    </button>
                    <?php
                    }else{
                        ?>
                        <a href="login.php" class="add_cart_btn">Add to Cart</a>
                        <?php
                    }
                    ?>
                 
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }
</script>
<?php include 'includes/footer.php'; ?>