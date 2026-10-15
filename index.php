<?php
include 'includes/header.php';
include 'includes/db_con.php'; ?>

<!-- Hero Section -->
 <div class="heroSection">
<div id="fashionSlider" class="carousel slide carousel-fade" data-bs-ride="carousel">

  <!-- Indicators -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#fashionSlider" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#fashionSlider" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#fashionSlider" data-bs-slide-to="2"></button>
    <button type="button" data-bs-target="#fashionSlider" data-bs-slide-to="3"></button>
  </div>

  <!-- Slides -->
  <div class="carousel-inner">

    <!-- MEN -->
    <div class="carousel-item active">
      <img src="images/slider-men.png" class="d-block w-100 slider-img" alt="Men Fashion">
      <div class="d-flex h-100">
        <div class="carousel-caption text-start">
          <h1>Men’s New Collection</h1>
          <p>Premium Shirts, Jeans & More</p>
          <a href="products.php?category=men" class="cust_btn">Shop Men</a>
        </div>
      </div>
    </div>

    <!-- WOMEN -->
    <div class="carousel-item">
      <img src="images/slider-woman.png" class="d-block w-100 slider-img" alt="Women Fashion">
      <div class="carousel-caption">
        <h1>Women’s Trending Styles</h1>
        <p>Ethnic & Western Wear</p>
        <a href="products.php?category=women" class="btn btn-light">Shop Women</a>
      </div>
    </div>

    <!-- BOYS -->
    <div class="carousel-item">
      <img src="images/slider-boys.png" class="d-block w-100 slider-img" alt="Boys Fashion">
      <div class="carousel-caption">
        <h1>Boys Collection</h1>
        <p>Cool & Comfortable Outfits</p>
        <a href="products.php?category=boys" class="btn btn-warning">Shop Boys</a>
      </div>
    </div>

    <!-- GIRLS -->
    <div class="carousel-item">
      <img src="images/slider-girls.png" class="d-block w-100 slider-img" alt="Girls Fashion">
      <div class="carousel-caption text-end">
        <h1>Girls Fashion</h1>
        <p>Cute Styles for Every Occasion</p>
        <a href="products.php?category=girls" class="btn btn-danger">Shop Girls</a>
      </div>
    </div>

  </div>

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#fashionSlider" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#fashionSlider" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>

</div>
</div>

<!-- End of Hero Section -->

<!-- Popular in Men -->
<section class="py-5">
  <div class="container py-3">
    <div class="row">
      <div class="col-12 pt-5 py-lg-0">
        <h2>Popular in Men</h2>
      </div>
    </div>
    <div class="row">
      <?php
      $sql = "SELECT 
    p.id,
    p.name,
    p.price,
    p.description,
    (
        SELECT image 
        FROM product_images 
        WHERE product_id = p.id 
        ORDER BY id ASC 
        LIMIT 1
    ) AS image
FROM products p
WHERE p.category_id = 1
LIMIT 4
";
      $men_res = mysqli_query($conn, $sql);
      if (mysqli_num_rows($men_res) == 0) {
        echo "<h3>No products available in this category</h3>";
      }
      while ($row = mysqli_fetch_assoc($men_res)) {
        $id = $row['id'];
        $name = $row['name'];
        $img = $row['image'];
        $description = $row['description'];
        $price = $row['price'];
        ?>
        <div class="col-lg-3 py-lg-0 py-3">
          <div class="card">
            <img src="<?php echo $img ?>" class="card-img-top" alt="..." />
            <div class="card-body">
              <h5><?php echo $name ?></h5>
              <h6 class="text-success">₹<?php echo $price ?></h6>
              <div class="mt-4">
                <a href="product-detail.php?id=<?php echo $id; ?>" class="cust_btn view_btn">View</a>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
    <div class="row py-3">
      <div class="col-12">
        <a href="products.php?category=men" class="cust_btn">View All</a>
      </div>
    </div>
  </div>
</section>
<!-- End of Popular in Men -->
<!-- Popular in Women -->
<section class="py-3">
  <div class="container py-3">
    <div class="row">
      <div class="col-12">
        <h2>Popular in Women</h2>
      </div>
    </div>
    <div class="row">
      <?php
      $sql = "SELECT 
    p.id,
    p.name,
    p.price,
    p.description,
    (
        SELECT image 
        FROM product_images 
        WHERE product_id = p.id 
        ORDER BY id ASC 
        LIMIT 1
    ) AS image
FROM products p
WHERE p.category_id = 2
LIMIT 4
";
      $women_res = mysqli_query($conn, $sql);
      if (mysqli_num_rows($women_res) == 0) {
        echo "<h3>No products available in this category</h3>";
      }
      while ($row = mysqli_fetch_assoc($women_res)) {
        $id = $row['id'];
        $name = $row['name'];
        $img = $row['image'];
        $description = $row['description'];
        $price = $row['price'];
        ?>
        <div class="col-lg-3 py-lg-0 py-3">
          <div class="card">
            <img src="<?php echo $img ?>" class="card-img-top" alt="..." />
            <div class="card-body">
              <h5><?php echo $name ?></h5>
              <h6 class="text-success">₹<?php echo $price ?></h6>
              <div class="mt-4">
                <a href="product-detail.php?id=<?php echo $id; ?>" class="cust_btn view_btn">View</a>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
    <div class="row py-3">
      <div class="col-12">
        <a href="products.php?category=women" class="cust_btn">View All</a>
      </div>
    </div>
  </div>
</section>
<!-- End of Popular in Women -->
<!-- Popular in Boys -->
<section class="py-3">
  <div class="container py-3">
    <div class="row">
      <div class="col-12">
        <h2>Popular in Boys</h2>
      </div>
    </div>
    <div class="row">
      <?php
      $sql = "SELECT 
    p.id,
    p.name,
    p.price,
    p.description,
    (
        SELECT image 
        FROM product_images 
        WHERE product_id = p.id 
        ORDER BY id ASC 
        LIMIT 1
    ) AS image
FROM products p
WHERE p.category_id = 3
LIMIT 4
";
      $boy_res = mysqli_query($conn, $sql);
      if (mysqli_num_rows($boy_res) == 0) {
        echo "<h3>No products available in this category</h3>";
      }
      while ($row = mysqli_fetch_assoc($boy_res)) {
        $id = $row['id'];
        $name = $row['name'];
        $img = $row['image'];
        $description = $row['description'];
        $price = $row['price'];
        ?>
        <div class="col-lg-3 py-lg-0 py-3">
          <div class="card">
            <img src="<?php echo $img ?>" class="card-img-top" alt="..." />
            <div class="card-body">
              <h5><?php echo $name ?></h5>
              <h6 class="text-success">₹<?php echo $price ?></h6>
              <div class="mt-4">
                <a href="product-detail.php?id=<?php echo $id; ?>" class="cust_btn view_btn">View</a>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
    <div class="row py-3">
      <div class="col-12">
        <a href="products.php?category=boys" class="cust_btn">View All</a>
      </div>
    </div>
  </div>
</section>
<!-- End of Popular in Boys -->
<!-- Popular in Girls -->
<section class="py-3">
  <div class="container py-3">
    <div class="row">
      <div class="col-12">
        <h2>Popular in Girls</h2>
      </div>
    </div>
    <div class="row">
     <?php
      $sql = "SELECT 
    p.id,
    p.name,
    p.price,
    p.description,
    (
        SELECT image 
        FROM product_images 
        WHERE product_id = p.id 
        ORDER BY id ASC 
        LIMIT 1
    ) AS image
FROM products p
WHERE p.category_id = 4
LIMIT 4
";
      $g_res = mysqli_query($conn, $sql);
      if (mysqli_num_rows($g_res) == 0) {
        echo "<h3>No products available in this category</h3>";
      }
      while ($row = mysqli_fetch_assoc($g_res)) {
        $id = $row['id'];
        $name = $row['name'];
        $img = $row['image'];
        $description = $row['description'];
        $price = $row['price'];
        ?>
        <div class="col-lg-3 py-lg-0 py-3">
          <div class="card">
            <img src="<?php echo $img ?>" class="card-img-top" alt="..." />
            <div class="card-body">
              <h5><?php echo $name ?></h5>
              <h6 class="text-success">₹<?php echo $price ?></h6>
              <div class="mt-4">
                <a href="product-detail.php?id=<?php echo $id; ?>" class="cust_btn view_btn">View</a>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
    <div class="row py-3">
      <div class="col-12">
        <a href="products.php?category=girls" class="cust_btn">View All</a>
      </div>
    </div>
  </div>
</section>
<!-- End of Popular in Girls -->


<?php include 'includes/footer.php' ?>