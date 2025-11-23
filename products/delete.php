<?php
include "../includes/db.php";
include "../includes/auth_check.php";
include "../includes/audit.php";


// 1. Check if the product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$id = intval($_GET['id']);

// 2. Fetch the product first to get its name for the audit log
$stmt = $conn->prepare("SELECT name FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

$name = $product['name']; // store name for audit

// 2. Prepare DELETE statement
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    // After deletion
    log_action($conn, $_SESSION['user_id'], 'delete', 'products', $id, "Deleted product $name");

    // Successfully deleted, redirect back to product list
    header("Location: list.php?msg=deleted");
    exit();
} else {
    echo "Error deleting product: " . $conn->error;
}
