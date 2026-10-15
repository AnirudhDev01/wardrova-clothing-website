<?php include '../includes/db_con.php';
include 'includes/header.php';
if(!isset($_SESSION['admin_logged_in'])){
    header('location: index.php');
    exit;
}
$sql = "SELECT p.name, p.price, p.id, c.name AS category FROM products p JOIN categories c on p.category_id=c.id";
$res = mysqli_query($conn, $sql);
?>
<section class="py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Category</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sno = 1;
                        while ($row = mysqli_fetch_assoc($res)) {
                         
            $img_q = mysqli_query(
                $conn,
                "SELECT image FROM product_images 
                 WHERE product_id = ".$row['id']." 
                 LIMIT 1"
            );
            $img = mysqli_fetch_assoc($img_q);
         

                            ?>
                                <tr>
                            <th scope="row"><?php echo $sno++ ?></th>
                            <td><img src="../<?= $img['image']; ?>" class="img-fluid" width="50" height="50"></td>
                             <td><?= $row['name'] ?></td>
                                     <td>₹<?= $row['price'] ?></td>
                            <td class="text-capitalize"><?= $row['category'] ?></td>
                            <td>

                                <a href="edit_product.php?edit_id=<?= $row['id'] ?>" class="btn btn-warning"><i
                                        class="fas fa-pencil"></i></a>
                                <a onclick="return confirm('Are you Sure?')"
                                    href="delete_product.php?delete_id=<?= $row['id']; ?>" class="btn btn-danger"><i
                                        class="fas fa-trash"></i></a>
            
            </td>
            </tr>
                            <?php
                        }
                        ?>
                    


                           
                    
            </table>
        </div>
    </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>