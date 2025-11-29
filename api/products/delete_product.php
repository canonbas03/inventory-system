<?php
include "../../includes/auth_check.php";
include "../../includes/db.php";
include "../../includes/audit.php";


if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die("Invalid product ID.");
}

$id = intval($_POST['id']);


// audit log
$stmt = $conn->prepare("SELECT name FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

$name = $product['name'];

$sql = "DELETE FROM products WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    log_action($conn, $_SESSION['user_id'], 'delete', 'products', $id, "Deleted product $name");

    exit();
} else {
    echo "Error deleting product: " . $conn->error;
}
