<?php
include 'authentication.php';
include 'includes/conn.php';
$src = isset($src) ? $src : '';
$query = isset($_POST['query']) ? trim($_POST['query']) : '';
if ($query !== '') {
    $sql = "SELECT pl.product_name, pl.category, pl.price, pl.product_picture, inv.quantity, inv.product_code 
            FROM product_list pl
            JOIN inventory inv ON pl.product_name = inv.product_name 
            WHERE inv.quantity > 0 AND (pl.product_name LIKE ? OR pl.category LIKE ? )";
    $stmt = $conn->prepare($sql);
    $like = "%$query%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT pl.product_name, pl.category, pl.price, pl.product_picture, inv.quantity, inv.product_code 
            FROM product_list pl
            JOIN inventory inv ON pl.product_name = inv.product_name 
            WHERE inv.quantity > 0";
    $result = $conn->query($sql);
}
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-lg-3 col-6">';
        echo '<a href="" class="product-link" data-product-id="' . $row['product_code'] . '">';
        echo '<div class="card">';
        echo '<img src="' . $src . $row['product_picture'] . '" class="card-img-top" alt="...">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $row['product_name'] . '</h5>';
        echo '<p class="card-text">Price: ' . $row['price'] . '</p>';
        if ($row['quantity'] == 0) {
            echo '<p class="card-text"><span class="badge bg-danger">Sold Out</span></p>';
        } else {
            echo '<p class="card-text"><span class="badge bg-success">Available</span></p>';
        }
        echo '</div></div></a></div>';
    }
} else {
    echo 'No products found.';
}
$conn->close(); 