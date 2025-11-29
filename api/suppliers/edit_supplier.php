<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_name = $supplier['name'];
    $old_phone = $supplier['phone'];
    $old_email = $supplier['email'];

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if (!empty($name) && !empty($phone) && !empty($email)) {
        $stmt = $conn->prepare("UPDATE suppliers SET name=?, phone=?, email=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $phone, $email, $id);
        if ($stmt->execute()) {
            log_action(
                $conn,
                $_SESSION['user_id'],
                'edit',
                'suppliers',
                $id,
                "User '{$_SESSION['username']}' updated supplier from '$old_name | $old_phone | $old_email' to '$name | $phone | $email'"
            );
            header("Location: list.php");
            exit;
        }
    } else {
        $error = "All fields are required.";
    }
}
