<?php include 'includes/header.php';
include 'includes/db_con.php';
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM `users` WHERE id=$user_id";
$res = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($res);
if (isset($_POST['upd_pro_btn'])) {
    $fname = $_POST['upd_fname'];
    $lname = $_POST['upd_lname'];
    $password = $_POST['upd_password'];
    if ($fname == "" || $lname == "") {
        $error = "First name and Last name are required";
    } else {
$sql = "UPDATE `users` SET fname='$fname', lname='$lname' WHERE id=$user_id";
$res = mysqli_query($conn,$sql);

        if (!empty($password)) {
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE `users` SET password='$hash_password' WHERE id=$user_id";
            $res = mysqli_query($conn, $sql);
        }
         $success = "Profile updated successfully!";
         header('location: my_profile.php');
    }
}
?>
<section class="py-5">
    <div class="container py-5">
        <div class="row">
            
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php } ?>

      <?php if (isset($success)) { ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php } ?>
                        <h4>My Profile</h4>

                        <form method="post">
                            <div class="mb-3">
                                <input type="email" name="email" value="<?= $user['email'] ?>" class="form-control"
                                    readonly disabled>
                            </div>
                            <div class="mb-3">
                                <label for="upd_fname">First Name: </label>
                                <input type="text" name="upd_fname" value="<?= $user['fname'] ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="upd_lname">Last Name: </label>
                                <input type="text" name="upd_lname" value="<?= $user['lname'] ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="upd_lname">New Password: </label>
                                <input type="password" name="upd_password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="upd_pro_btn" class="cust_btn w-100">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>