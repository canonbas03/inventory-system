<?php
include "../../includes/auth_check.php";
include "../../includes/db.php";
include "../../includes/audit.php";


if (!isset($_POST['id'])) {
    echo "Missing ID";
    exit;
}

$supplier_id = intval($_POST['id'] ?? 0);
$new_name = trim($_POST['name'] ?? '');
$new_phone = trim($_POST['phone'] ?? '');
$new_email = trim($_POST['email'] ?? '');

$isValid = true;
if (
    !$supplier_id || empty($new_name) || empty($new_phone) || empty($new_email)
) {
    $isValid = false;
}

if ($isValid) {

    // Get old quantity
    $sql = "SELECT name, phone, email FROM suppliers WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $supplier_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $old_name = $row['name'];
    $old_phone = $row['phone'];
    $old_email = $row['email'];


    $sql = "UPDATE suppliers SET name=?, phone=?, email=? WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $new_name, $new_phone, $new_email, $supplier_id);
    if ($stmt->execute()) {
        // Log audit
        $old_supplier_state = "[$old_name | $old_phone | $old_email]";
        $new_supplier_state = "[$new_name | $new_phone | $new_email]";
        log_action($conn, $_SESSION['user_id'], 'edit', 'suppliers', $supplier_id, "Edited supplier From: $old_supplier_state To: $new_supplier_state");
    }

    echo "OK";
    exit;
} else {
    echo "DB error";
}
