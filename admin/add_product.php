<?php include '../includes/db_con.php';
include 'includes/header.php';
if(!isset($_SESSION['admin_logged_in'])){
    header('location: index.php');
    exit;
}
$cat_q = "SELECT * FROM `categories`";
$cat_res = mysqli_query($conn, $cat_q);
if (isset($_POST['add_prod_btn'])) {
    $category_id = $_POST['category_id'];
    $name = $_POST['prod_name'];
    $description = $_POST['prod_description'];
    $price = $_POST['price'];

    $sql = "INSERT INTO `products` (category_id,name,description,price) VALUES('$category_id','$name','$description','$price')";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $product_id = mysqli_insert_id($conn);
        if (!empty($_POST['sizes'])) {
            foreach ($_POST['sizes'] as $size) {
                $stock = $_POST['stock'][$size];
                $query = "INSERT INTO `product_sizes` (product_id,size,stock) VALUES('$product_id','$size','$stock')";
                $res = mysqli_query($conn, $query);
            }
        }
        foreach ($_FILES['images']['name'] as $key => $img_name) {
            if ($img_name != '') {
                $tmp_name = $_FILES['images']['tmp_name'][$key];
                $path = "images/products/" . "PROD_". time() . '_' . $img_name;
                move_uploaded_file($tmp_name, "../" . $path);
                $img_query = "INSERT INTO `product_images` (product_id,image) VALUES('$product_id','$path')";
                $res = mysqli_query($conn, $img_query);
            }
        }
        echo "<script>alert('Product added successfully')</script>";
    }


}
?>
<section class="py-5 my-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h4>Add New Product</h4>
                        <form method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="prod_name">Product Name: </label>
                                <input type="text" class="form-control" name="prod_name" required>
                            </div>
                            <div class="mb-3">
                                <lebel for="price">Price:</lebel>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" name="price" id="" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="prod_name">Description: </label>
                                <textarea name="prod_description" id="" class="form-control"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="product_category">Category: </label>
                                <select name="category_id" id="" class="form-select">
                                    <option value="">Select Category</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($cat_res)) {
                                        ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="mb-2">Available Sizes: </label>
                                <?php foreach (['S', 'M', 'L', 'XL', 'XXL'] as $s) { ?>
                                    <div
                                        style="border: 1px solid #ddd; padding: 10px; margin-bottom: 8px; border-radius: 5px;">
                                        <div class="form-check">
                                            <input type="checkbox" name="sizes[]" value="<?php echo $s; ?>"
                                                id="size_<?php echo $s; ?>" class="form-check-input">
                                            <label for="size_<?php echo $s ?>"
                                                class="form-check-label"><?php echo $s ?></label>
                                        </div>
                                        <input required type="number" name="stock[<?php echo $s ?>]"
                                          min="0" value="0"  placeholder="Stock for size: <?php echo $s; ?>" id="" class="form-control mt-2">
                                    </div>
                                <?php } ?>
                            </div>


                            <div class="mb-3">
                                <label for="images[]">Images:</label>
                                <input type="file" name="images[]" id="" class="form-control" multiple required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="cust_btn w-100" name="add_prod_btn">Add Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php';?>