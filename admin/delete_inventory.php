<?php
include 'includes/conn.php';
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare('DELETE FROM inventory WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo 'success';
} else {
    echo 'error';
}
?>