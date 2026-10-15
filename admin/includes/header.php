<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wardrova - Admin</title>
    <style>
              .size-box {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 8px;
        }
        .img-box {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }
        .img-box img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
        .img-box a {
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            text-decoration: none;
        }
    </style>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
      crossorigin="anonymous"
    />
    <!-- Font Awesome CSS -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
      integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css" />
  </head>
  <body>
    <!-- Navbar -->
    <nav
      class="navbar navbar-expand-lg bg-nav fixed-top shadow"
      data-bs-theme="dark"
    >
      <div class="container">
        <a class="navbar-brand" href="dashboard.php"><img src="../images/logo2.png" class="img-fluid" width="120px"></a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="add_product.php" class="nav-link">Add Product</a>
            </li>
            <li class="nav-item">
                <a href="product_list.php" class="nav-link">View Products</a>
            </li>
            <li class="nav-item">
                <a href="orders.php" class="nav-link">View Orders</a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End of Navbar -->