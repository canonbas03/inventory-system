<?php
include "../../includes/auth_check.php";
include "../../includes/db.php";
include "../../includes/audit.php";


$name = trim($_POST["name"] ?? '');
$sku = trim($_POST["sku"] ?? '');
$quantity = intval($_POST["quantity"] ?? 0);
$price = floatval($_POST["price"] ?? 0.0);
$category_id = intval($_POST["category"] ?? 0);
$supplier_id = intval($_POST["supplier"] ?? 0);
$critical = intval($_POST["critical"] ?? 0);

$isValid = true;
if (
    empty($name) ||
    empty($sku) ||
    $quantity <= 0 ||
    $price < 0 ||
    !$category_id ||
    !$supplier_id
) {
    $isValid = false;
}

if ($isValid) {

    $stmt = $conn->prepare("
            INSERT INTO products (name, sku, quantity, price, category_id, supplier_id, critical_level)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
    $stmt->bind_param("ssidiii", $name, $sku, $quantity, $price, $category_id, $supplier_id, $critical);

    if ($stmt->execute()) {
        $product_id = $stmt->insert_id;

        $change_amount = $quantity; // initial movement is +quantity
        $old_quantity = 0;
        $new_quantity = $quantity;

        $mov = $conn->prepare("
                        INSERT INTO stock_movements 
                        (product_id, change_amount, old_quantity, new_quantity, reason, created_by)
                        VALUES (?, ?, ?, ?, 'add', ?)
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
        log_action($conn, $_SESSION['user_id'], 'add', 'products', $product_id, "Added product $name");

        echo "OK";
        exit;
    } else {
        echo "<p style='color:red;'>Error adding product: " . $conn->error . "</p>";
    }
} else {
    echo "Name, SKU, category, and supplier are required!";
}
