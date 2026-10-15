<?php session_start();
include 'includes/db_con.php';
if (isset($_POST['register_btn'])) {
    $firstName = trim($_POST['fname']);
    $lastName = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    if ($firstName == '' || $lastName == '' || $email == '' || $password == '' || $cpassword == '') {
        // echo "<script>alert('All Fields are required!')</script>";
        $_SESSION['error'] = "All Fields are required!";
        header('location: register.php');
        exit;
    }
    if ($password != $cpassword) {
        // echo "<script>alert('Passwords do not match!')</script>";
        $_SESSION['error'] = "Passwords do not match!";
        header('location: register.php');
        exit;
    }
    $sql = "SELECT * FROM `users` WHERE email='$email'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        // echo "<script>alert('Email already exists')</script>";
        $_SESSION['error'] = "Email already exists!";
        header('location: register.php');
        exit;
    } else {
        $sql = "INSERT INTO `users` (fname,lname,email,password) VALUES('$firstName','$lastName','$email','$hash_password')";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            $_SESSION['success'] = "Registration successful! Please login.";
            header('location: register.php');
            exit;
        } else {
            $_SESSION['error'] = "Something went wrong! Please try again later.";
            header('location: register.php');
            exit;
        }
    }
}
if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($email == "" || $password == "") {
        $_SESSION['error'] = "All Fields are required!";
        header('location: login.php');
        exit;
    }
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM `users` WHERE email='$email'";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $hash = $row['password'];
        if (password_verify($password, $hash)) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['fname'] . ' ' . $row['lname'];
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_role'] = 'user';
            header('location: index.php');
            exit;
        }
    } else {
        header('location: login.php');
        exit;
    }
}

?>