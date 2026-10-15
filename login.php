<?php
include 'includes/header.php'; ?>
<section class="py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Login</h3>
                        <?php if (isset($_SESSION['error'])) {
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>".$_SESSION['error']."</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                            unset($_SESSION['error']);
                        }
                        ?>
                        <form action="code.php" method="post">
                            <div class="mb-3">
                                <label for="email">Email:</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="password">Password:</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="login_btn" class="cust_btn w-100">Login</button>
                                <a href="register.php" class="text-decoration-underline">Don't have an account? Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>