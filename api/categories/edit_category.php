<?php
include "../../includes/auth_check.php";
include "../../includes/db.php";
include "../../includes/audit.php";

if (!isset($_POST['id'])) {
    echo "Missing ID";
    exit;
}

$category_id = intval($_POST['id'] ?? 0);
$new_name = trim($_POST['name'] ?? '');

$isValid = true;

if (!$category_id || empty($new_name)) {
    $isValid = false;
}

if ($isValid) {

    // Get old category name
    $sql = "SELECT name FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "Category not found";
        exit;
    }

    $old_name = $row['name'];

    // Update
    $sql = "UPDATE categories SET name=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_name, $category_id);

    if ($stmt->execute()) {

        $old_cat = "[$old_name]";
        $new_cat = "[$new_name]";

        log_action(
            $conn,
            $_SESSION['user_id'],
            'edit',
            'categories',
            $category_id,
            "Edited category From: $old_cat To: $new_cat"
        );

        echo "OK";
        exit;
    } else {
        echo "DB error";
    }
} else {
    echo "Invalid data.";
}
