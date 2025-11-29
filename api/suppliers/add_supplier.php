<?php
include "../../includes/auth_check.php";
include "../../includes/db.php";
include "../../includes/audit.php";


$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');

$isValid = true;
if (
    empty($name) ||
    empty($phone) ||
    empty($email)
) {
    $isValid = false;
}

if ($isValid) {

    $sql = "INSERT INTO suppliers (name, phone, email) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $phone, $email);

    if ($stmt->execute()) {

        log_action(
            $conn,
            $_SESSION['user_id'],
            'add',
            'suppliers',
            $conn->insert_id,
            "User '{$_SESSION['username']}' added supplier '$name'."
        );

        echo "OK";
        exit;
    } else {
        echo "Error adding supplier: " . $conn->error;
    }
} else {
    echo "All fields are required.";
}
