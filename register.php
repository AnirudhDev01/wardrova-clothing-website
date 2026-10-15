<?php
include 'includes/header.php';

?>
<section class="py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Register</h3>
                        <?php if (isset($_SESSION['error'])) {
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>".$_SESSION['error']."</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['success'])) {
                             echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>".$_SESSION['success']."</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                            unset($_SESSION['success']);
                        }
                        ?>
                        <form action="code.php" method="post">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="fname">First Name: </label>
                                        <input type="text" name="fname" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="lname">Last Name: </label>
                                        <input type="text" name="lname" id="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="password">Password:</label>
                                <input type="password" name="password" id="" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="cpassword">Confirm Password:</label>
                                <input type="password" name="cpassword" id="" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="cust_btn w-100" name="register_btn">Register</button>
                                <a href="login.php" class="text-decoration-underline">Already have an account? Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>