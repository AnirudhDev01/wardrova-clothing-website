<?php 
include '../includes/db_con.php';

if(!isset($_GET['id'],$_GET['pid'])){
    header('location: product_list.php');
    exit;
}
$id  = (int)$_GET['id'];
$pid = (int)$_GET['pid'];

$img_q = mysqli_query($conn, "SELECT image FROM product_images WHERE id=$id");
$img = mysqli_fetch_assoc($img_q);

if ($img) {
    $path = "../" . $img['image'];
    if(file_exists($path)){
    unlink($path);
    }
    mysqli_query($conn, "DELETE FROM product_images WHERE id=$id");
}

header("Location: edit_product.php?edit_id=$pid");
exit;
?>