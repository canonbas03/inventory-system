<?php
include "../includes/db.php";
include "../includes/auth_check.php";

// 1. Check if the product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$id = intval($_GET['id']);

// 2. Prepare DELETE statement
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Successfully deleted, redirect back to product list
    header("Location: list.php?msg=deleted");
    exit();
} else {
    echo "Error deleting product: " . $conn->error;
}
