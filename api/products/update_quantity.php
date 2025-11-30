<?php
include "../../includes/db.php";
include "../../includes/audit.php";
session_start();

$id = intval($_POST['id']);
$amount = intval($_POST['amount']);
$type = $_POST['type'];

if ($amount <= 0 || ($type !== "increase" && $type !== "decrease")) {
    echo "Invalid data";
    exit;
}

if ($type === "decrease") {
    $q = $conn->prepare("UPDATE products SET quantity = GREATEST(quantity - ?, 0) WHERE id = ?");
} else {
    $q = $conn->prepare("UPDATE products SET quantity = quantity + ? WHERE id = ?");
}

$q->bind_param("ii", $amount, $id);

if ($q->execute()) {
    log_action(
        $conn,
        $_SESSION['user_id'],
        'update_quantity',
        'products',
        $id,
        ucfirst($type) . " quantity by $amount"
    );
    echo "OK";
} else {
    echo "Error";
}
