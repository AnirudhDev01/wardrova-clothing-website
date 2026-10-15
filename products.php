<?php
include 'includes/db_con.php';
include 'includes/header.php';

$search_sql = '';
$search_param = '';
if(isset($_GET['search']) && trim($_GET['search'] !== '')){
    $search = mysqli_real_escape_string($conn,$_GET['search']);
    $search_sql = "AND (p.name LIKE '%$search%' OR p.description LIKE '%$search%' OR c.name LIKE '%$search%')";
    $search_param = "&search=".urlencode($_GET['search']);
}



/* PAGINATION SETTINGS */
$limit = 8;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

/* CATEGORY FILTER */
$category_sql = '';
$category_param = '';

if (isset($_GET['category'])) {
    $category = mysqli_real_escape_string($conn, $_GET['category']);
    $category_sql = "AND c.name = '$category'";
    $category_param = "&category=$category";
}

/* TOTAL PRODUCTS COUNT */
$count_sql = "
    SELECT COUNT(*) AS total
    FROM products p JOIN categories c ON
    p.category_id = c.id WHERE 1
    $category_sql
    $search_sql
";
$count_res = mysqli_query($conn, $count_sql);
$total_row = mysqli_fetch_assoc($count_res);
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);

/* PRODUCTS QUERY */
$sql = "
    SELECT 
        p.id,
        p.name,
        p.price,
        (
            SELECT image 
            FROM product_images 
            WHERE product_id = p.id 
            ORDER BY id ASC 
            LIMIT 1
        ) AS image
    FROM products p
    JOIN categories c ON 
    p.category_id=c.id WHERE 1
    $category_sql
    $search_sql
    LIMIT $offset, $limit
";
$res = mysqli_query($conn, $sql);
?>

<section class="py-5">
    <div class="container py-5">

        <!-- HEADING -->
        <div class="row mb-4">
            <div class="col-12">
                <h3>
                    <?php
                    if(!empty($_GET['search'])){
                        echo 'Search results for"'. htmlspecialchars($_GET['search']) . '"';
                    }elseif(!empty($_GET['category'])){
                        echo htmlspecialchars($_GET['category']);
                    }else{
                        echo "All Products";
                    }
                    ?>
                </h3>
            </div>
        </div>

        <!-- PRODUCTS GRID -->
        <div class="row">
            <?php if (mysqli_num_rows($res) == 0) { ?>
                <h4>No products found</h4>
            <?php } ?>

            <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 py-lg-0 py-3">
                    <div class="card h-100">

                        <!-- PRODUCT IMAGE -->
                        <img src="<?= $row['image'] ?? 'images/no-image.png'; ?>" class="card-img-top"
                            style="height:250px; object-fit:contain;">

                        <div class="card-body text-center">
                            <h5><?= htmlspecialchars($row['name']); ?></h5>
                            <h6 class="text-success">₹<?= $row['price']; ?></h6>

                            <!-- ACTIONS -->
                            <div class="mt-3">


                                <!-- ADD TO CART -->
                                <form method="post" action="add_to_cart.php">

                                    <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                                    <input type="hidden" name="quantity" value="1">

                                    <?php
                                    /* Fetch sizes with stock */
                                    $size_q = mysqli_query(
                                        $conn,
                                        "SELECT size FROM product_sizes 
                                     WHERE product_id='{$row['id']}' 
                                     AND stock > 0"
                                    );
                                    ?>

                                    <?php if (mysqli_num_rows($size_q) > 0) { ?>
                                        <select name="size" class="form-select mb-2" required>
                                            <?php while ($s = mysqli_fetch_assoc($size_q)) { ?>
                                                <option value="<?= $s['size']; ?>">
                                                    <?= $s['size']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>

                                        <button type="submit" class="add_cart_btn w-100">
                                            Add to Cart
                                        </button>
                                    <?php } else { ?>
                                        <button class="btn btn-secondary w-100" disabled>
                                            Out of Stock
                                        </button>
                                    <?php } ?>
                                    <a href="product-detail.php?id=<?= $row['id']; ?>" class="cust_btn mb-2 d-inline-block w-100">
                                        View
                                    </a>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- PAGINATION -->
        <?php if ($total_pages > 1) { ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">

                    <!-- PREVIOUS -->
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 . $category_param . $search_param ?>">
                            Previous
                        </a>
                    </li>

                    <!-- PAGE NUMBERS -->
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i . $category_param . $search_param ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php } ?>

                    <!-- NEXT -->
                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 . $category_param ?>">
                            Next
                        </a>
                    </li>

                </ul>
            </nav>
        <?php } ?>

    </div>
</section>

<?php include 'includes/footer.php'; ?>