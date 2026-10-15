<?php include '../includes/db_con.php';

if (!isset($_GET['delete_id'])) {
    header('location: dashboard.php');
    exit;
}
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $sql = "SELECT * FROM `product_images` WHERE product_id=$id";
    $res = mysqli_query($conn, $sql);
    while ($img = mysqli_fetch_assoc($res)) {
        $path = "../" . $img['image'];
        if (file_exists($path)) {
            unlink($path);
        }
    }
    
    $product_del = "DELETE FROM `products` WHERE id=$id";
    $product_res = mysqli_query($conn,$product_del);
    header('location: product_list.php');
    exit;
}
?>