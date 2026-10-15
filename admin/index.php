<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Custom CSS -->
         <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <a href="../index.php" class="btn btn-warning">Go back to Home</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="card">
                        <div class="card-heading">
                            <h3>Admin Login</h3>
                            </div>
                        <div class="card-body">
                            
                            <form action="code.php" method="post">
                                <div class="mb-3">
                                      <?php if (isset($_SESSION['error'])) {
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>".$_SESSION['error']."</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                            unset($_SESSION['error']);
                        }?>   
                                </div>
                                <div class="mb-3">
                                <label for="email">Email: </label>
                                <input type="email" name="email" id="" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="password">Password:</label>
                                    <input type="password" name="password" id="" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="cust_btn w-100" name="admin_login_btn">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>