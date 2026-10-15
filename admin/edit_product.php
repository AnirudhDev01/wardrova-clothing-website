<?php
include 'includes/header.php';
include '../includes/db_con.php';
if(!isset($_SESSION['admin_logged_in'])){
    header('location: index.php');
    exit;
}
if (!isset($_GET['edit_id'])) {
    header('location: product_list.php');
    exit;
}

$id = (int)$_GET['edit_id'];

/* Fetch product */
$res = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
if (mysqli_num_rows($res) == 0) {
    echo "<script>alert('No Product Found!');window.location='product_list.php';</script>";
    exit;
}
$product = mysqli_fetch_assoc($res);

/* Categories */
$cat_res = mysqli_query($conn, "SELECT * FROM categories");

/* Sizes */
$size_res = mysqli_query($conn, "SELECT * FROM product_sizes WHERE product_id = $id");
$sizes = [];
while ($s = mysqli_fetch_assoc($size_res)) {
    $sizes[$s['size']] = $s['stock'];
}

/* Images */
$img_res = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id = $id");

/* UPDATE PRODUCT */
if (isset($_POST['edit_prod_btn'])) {

    $category_id = $_POST['category_id'];
    $name        = $_POST['edit_prod_name'];
    $description = $_POST['edit_prod_desc'];
    $price       = $_POST['edit_price'];

    mysqli_query(
        $conn,
        "UPDATE products 
         SET category_id='$category_id',
             name='$name',
             description='$description',
             price='$price'
         WHERE id='$id'"
    );

    /* Update sizes */
    mysqli_query($conn, "DELETE FROM product_sizes WHERE product_id = $id");

    if (!empty($_POST['sizes'])) {
        foreach ($_POST['sizes'] as $size) {
            $stock = $_POST['stock'][$size] ?? 0;

            mysqli_query(
                $conn,
                "INSERT INTO product_sizes (product_id, size, stock)
                 VALUES ('$id', '$size', '$stock')"
            );
        }
    }

    /* Add new images */
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['name'] as $key => $img_name) {
            if ($img_name == '') continue;

            $tmp  = $_FILES['images']['tmp_name'][$key];
            $path = "images/products/" . time() . "_" . $img_name;

            move_uploaded_file($tmp, "../" . $path);

            mysqli_query(
                $conn,
                "INSERT INTO product_images (product_id, image)
                 VALUES ('$id', '$path')"
            );
        }
    }

    echo "<script>alert('Product updated successfully!');window.location='product_list.php';</script>";
    exit;
}
?>

<section class="py-5 my-3">
<div class="container">
<div class="row">
<div class="col-lg-6 mx-auto">
<div class="card">
<div class="card-body">

<h4>Edit Product</h4>

<form method="post" enctype="multipart/form-data">

    <div class="mb-3">
        <label>Product Name</label>
        <input type="text" name="edit_prod_name"
               class="form-control"
               value="<?= htmlspecialchars($product['name']) ?>" required>
    </div>

    <div class="mb-3">
        <label>Price</label>
        <input type="number" name="edit_price"
               class="form-control"
               value="<?= $product['price'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="edit_prod_desc"
                  class="form-control"><?= htmlspecialchars($product['description']) ?></textarea>
    </div>

    <div class="mb-3">
        <label>Category</label>
        <select name="category_id" class="form-select" required>
            <option value="">Select Category</option>
            <?php while ($cat = mysqli_fetch_assoc($cat_res)) { ?>
                <option value="<?= $cat['id']; ?>"
                    <?= ($cat['id'] == $product['category_id']) ? 'selected' : '' ?>>
                    <?= ucfirst($cat['name']); ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="mb-2">Available Sizes</label>
        <?php foreach (['S','M','L','XL','XXL'] as $s) { ?>
            <div class="border p-2 mb-2 rounded">
                <div class="form-check">
                    <input type="checkbox"
                           class="form-check-input"
                           name="sizes[]"
                           value="<?= $s ?>"
                           id="size_<?= $s ?>"
                           <?= isset($sizes[$s]) ? 'checked' : '' ?>>
                    <label class="form-check-label"><?= $s ?></label>
                </div>

                <input type="number"
                       name="stock[<?= $s ?>]"
                       class="form-control mt-2"
                       value="<?= $sizes[$s] ?? '' ?>"
                       placeholder="Stock for <?= $s ?>">
            </div>
        <?php } ?>
    </div>

    <div class="mb-3">
        <label class="fw-bold">Existing Images</label><br>
        <?php while ($img = mysqli_fetch_assoc($img_res)) { ?>
            <div class="img-box d-inline-block me-2">
                <img src="../<?= $img['image']; ?>" width="80">
                <a href="product_image_delete.php?id=<?= $img['id']; ?>&pid=<?= $id; ?>"
                   onclick="return confirm('Delete image?')">X</a>
            </div>
        <?php } ?>
    </div>

    <div class="mb-3">
        <label>Add New Images</label>
        <input type="file" name="images[]" class="form-control" multiple>
    </div>

    <button type="submit" name="edit_prod_btn" class="cust_btn w-100">
        Update Product
    </button>

</form>

</div>
</div>
</div>
</div>
</div>
</section>

<?php include 'includes/footer.php'; ?>
