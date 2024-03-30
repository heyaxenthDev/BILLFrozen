<?php
include 'includes/conn.php';
// header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productCode = $_POST['productCode'];

    // Assuming $conn is your database connection
    // Perform database query to fetch product details
    $sql = "SELECT pl.product_name, pl.category, pl.price, pl.product_picture, inv.quantity, inv.product_code 
            FROM product_list pl
            JOIN inventory inv ON pl.product_name = inv.product_name 
            WHERE inv.product_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(array("error" => "Product not found"));
    }
} else {
    echo json_encode(array("error" => "Invalid request method"));
}

?>