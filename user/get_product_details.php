<?php
// Assuming you have already connected to the database
$id = $_GET['id'];
$query = "SELECT `product_name`, `category`, `price`, `description`, `product_picture` FROM `product_list` WHERE `id` = $id";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
} else {
    echo json_encode(array('error' => 'Product not found'));
}
?>