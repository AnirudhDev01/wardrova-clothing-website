<?php 
$host = "localhost";
$user = "root";
$db_pass = "";
$db = "wardrova_v1";
$conn = mysqli_connect($host,$user,$db_pass,$db);
if(!$conn){
    echo "Connection failed! -".mysqli_connect_error();
}
?>