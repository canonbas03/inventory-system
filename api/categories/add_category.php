<?php
include "../../includes/auth_check.php";
include "../../includes/db.php";
include "../../includes/audit.php";

$name = trim($_POST['name'] ?? '');

$isValid = true;

if (empty($name)) {
    $isValid = false;
}

if ($isValid) {

    $sql = "INSERT INTO categories (name) VALUES (?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);

    if ($stmt->execute()) {

        log_action(
            $conn,
            $_SESSION['user_id'],
            'add',
            'categories',
            $conn->insert_id,
            "User '{$_SESSION['username']}' added category '$name'."
        );

        echo "OK";
        exit;
    } else {
        echo "Error adding category: " . $conn->error;
    }
} else {
    echo "Category name is required.";
}
