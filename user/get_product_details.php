<?php
$src = "../admin/";
include 'authentication.php';
checkLogin();
include "includes/conn.php";

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    
    // Fetch product details
    $sql = "SELECT pl.product_name, pl.category, pl.price, pl.product_picture, inv.quantity, inv.product_code 
            FROM product_list pl
            JOIN inventory inv ON pl.product_name = inv.product_name 
            WHERE inv.product_code = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        // Add the full path to the product picture
        $row['product_picture'] = $src . $row['product_picture'];
        
        // Return the data as JSON
        header('Content-Type: application/json');
        echo json_encode($row);
    } else {
        // Return error if product not found
        http_response_code(404);
        echo json_encode(['error' => 'Product not found']);
    }
} 

$conn->close();
?>