<?php include '../includes/db_con.php';
session_start();
if(isset($_POST['admin_login_btn'])){
       $email = $_POST['email'];
    $password = $_POST['password'];
    if($email == "" || $password == ""){
        $_SESSION['error'] = "All Fields are required!";
        header('location: index.php');
        exit;
    }
    $hash_password = password_hash($password,PASSWORD_DEFAULT);

    $sql = "SELECT * FROM `admin` WHERE email='$email'";
    $res = mysqli_query($conn,$sql);
    if(mysqli_num_rows($res)> 0){
        $row = mysqli_fetch_assoc($res);
        $hash = $row['password'];
        if(password_verify($password,$hash)){
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['username'];
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_role'] = 'admin';
            header('location: dashboard.php');
            exit;
        }
    }
}

?>