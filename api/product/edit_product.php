<?php
include "../../includes/auth_check.php";
include "../../includes/db.php";
include "../../includes/audit.php";


if (!isset($_POST['id'])) {
    echo "Missing ID";
    exit;
}

$product_id = intval($_POST['id']);
$new_name = $_POST['name'];
$new_price = floatval($_POST['price']);
$new_quantity = intval($_POST['quantity']);

// Get old quantity
$sql = "SELECT name, quantity, price FROM products WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$old_price = $row['price'];
$old_quantity = $row['quantity'];
$old_name = $row['name'];


$stmt = $conn->prepare("UPDATE products SET name=?, price=?, quantity=? WHERE id=?");
$stmt->bind_param("sdii", $new_name, $new_price, $new_quantity, $product_id);

if ($stmt->execute()) {

    $zero = 0;
    $change_amount = $new_quantity - $old_quantity;

    $mov = $conn->prepare("
                        INSERT INTO stock_movements 
                        (product_id, change_amount, old_quantity, new_quantity, reason, created_by)
                        VALUES (?, ?, ?, ?, 'adjust', ?)
                        ");

    $mov->bind_param(
        "iiiii",
        $product_id,
        $change_amount,
        $old_quantity,
        $new_quantity,
        $_SESSION['user_id']
    );

    $mov->execute();

    // Log audit
    $old_product_state = "[$old_name | $old_quantity | $old_price]";
    $new_product_state = "[$new_name | $new_quantity | $new_price]";
    log_action($conn, $_SESSION['user_id'], 'edit', 'products', $product_id, "Edited product From: $old_product_state To: $new_product_state");

    echo "OK";
    exit;
} else {
    echo "DB error";
}
