<?php
include 'includes/conn.php';
$query = isset($_POST['query']) ? trim($_POST['query']) : '';
if ($query !== '') {
    $sql = "SELECT * FROM `product_list` WHERE product_name LIKE ? OR category LIKE ?";
    $stmt = $conn->prepare($sql);
    $like = "%$query%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM `product_list`";
    $result = $conn->query($sql);
}
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-lg-2 col-6">';
        echo '<div class="card">';
        echo '<img src="' . $row['product_picture'] . '" class="card-img-top" alt="...">';
        echo '<div class="card-body">';
        echo '<h6 class="card-title">' . $row['product_name'] . '</h6>';
        echo '<p class="card-text fw-semibold">₱' . $row['price'] . '</p>';
        echo '<div class="d-grid gap-2 mx-auto">';
        echo '<button class="btn btn-primary" type="submit" name="editProduct" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-id="' . $row['id'] . '" data-product-name="' . htmlspecialchars($row['product_name']) . '" data-product-price="' . $row['price'] . '" data-product-category="' . htmlspecialchars($row['category']) . '" data-product-description="' . htmlspecialchars($row['description']) . '" data-product-picture="' . $row['product_picture'] . '">Edit</button>';
        echo '<a class="btn btn-danger del" data-product-idDel="' . $row['id'] . '">Delete</a>';
        echo '</div></div></div></div>';
    }
} else {
    echo 'No products found';
}
if (isset($stmt)) $stmt->close();
$conn->close(); 