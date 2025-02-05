<?php
session_start();
include_once 'includes/conn.php';

if (isset($_POST['id'])) {
    $productId = $_POST['id'];
    $query = "SELECT product_picture FROM product_list WHERE id = $productId";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        echo $row['product_picture'];
    }
}
?>