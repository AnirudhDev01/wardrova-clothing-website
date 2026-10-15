<?php session_start();
include 'includes/db_con.php';

$isUserLoggedIn = (
    isset($_SESSION['user_id'], $_SESSION['user_role']) &&
    $_SESSION['user_role'] === 'user'
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wardrova</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-nav fixed-top shadow" data-bs-theme="dark">
    <div class="container">
      <a class="navbar-brand" href="index.php"><img src="images/logo2.png" class="img-fluid" width="150px"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Products
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="products.php">All</a></li>
              <li><a class="dropdown-item" href="products.php?category=men">Men</a></li>
              <li><a class="dropdown-item" href="products.php?category=women">Women</a></li>
              <li><a class="dropdown-item" href="products.php?category=boys">Boys</a></li>
              <li><a class="dropdown-item" href="products.php?category=girls">Girls</a></li>
            </ul>
          </li>

              <?php if (!$isUserLoggedIn) : ?>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
        <?php endif; ?>
          <?php if ($isUserLoggedIn) {
            ?>
           <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= $_SESSION['user_name']?>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="orders.php">Orders</a></li>
              <li><a class="dropdown-item" href="my_profile.php">Profile</a></li>
            </ul>
          </li>
            <?php
            $cart_count = 0;
            if (isset($_SESSION['user_id'])) {
              $uid = $_SESSION['user_id'];
              $cart_count_q = "SELECT SUM(quantity) AS total_items FROM `cart` WHERE user_id=$uid";
              $cart_res = mysqli_query($conn, $cart_count_q);
              $cart_data = mysqli_fetch_assoc($cart_res);
              $cart_count = $cart_data['total_items'] ?? 0;
            }
            ;
            ?>
            <li class="nav-item">
              <?php if ($cart_count > 0) { ?>
                <a href="my_cart.php" class="nav-link cart-link">
                  <i class="fa-solid fa-cart-shopping fa-lg"></i>

                  <span id="cartBadge" class="cart-badge badge-active">
                    <?= $cart_count ?>
                  </span>
                </a>
              <?php } else { ?>
                <a href="#" class="nav-link cart-link cart-disabled" onclick="return false;" disabled>
                  <i class="fa-solid fa-cart-shopping fa-lg"></i>

                  <span id="cartBadge" class="cart-badge badge-empty">
                    0
                  </span>
                </a>
              <?php } ?>
            </li>
            <li class="nav-item">
              <a href="logout.php" class="nav-link">Logout</a>
            </li>
            <?php
          }
          ?>
          <form class="d-flex" method="get" action="products.php">
            <div class="input-group">
              <input type="search" id="search" class="form-control ms-3" name="search" placeholder="Search products..."
                value="<?= $_GET['search'] ?? '' ?>">
              <button class="cust_btn_search" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </form>

        </ul>
      </div>
    </div>
  </nav>
  <!-- End of Navbar -->