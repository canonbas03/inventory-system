<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/audit.php"; // make sure audit functions are included

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) die("Invalid category ID");

$id = intval($_GET['id']);

// Get category name for audit
$stmt = $conn->prepare("SELECT name FROM categories WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();

if (!$category) die("Category not found");

$category_name = $category['name'];

// Delete category
$stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $username = $_SESSION['username'];

    log_action(
        $conn,
        $_SESSION['user_id'],
        'delete',
        'categories',
        $id,
        "User '$username' deleted category '$category_name'"
    );

    header("Location: list.php");
    exit;
} else {
    echo "Error deleting category: " . $conn->error;
}
