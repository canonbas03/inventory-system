<?php
include "../../includes/auth_check.php";
include "../../includes/db.php";
include "../../includes/audit.php";


if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die("Invalid category ID.");
}

$id = intval($_POST['id']);


// audit log
$stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();

if (!$category) {
    die("Product not found.");
}

$name = $category['name'];

$sql = "DELETE FROM categories WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    log_action($conn, $_SESSION['user_id'], 'delete', 'categories', $id, "Deleted category $name");

    exit();
} else {
    echo "Error deleting category: " . $conn->error;
}
