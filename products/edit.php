<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/header.php";
include "../includes/audit.php";


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) die("Invalid ID");

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) die("Product not found");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $sku = $_POST['sku'];
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category']);
    $supplier_id = intval($_POST['supplier']);
    $critical = intval($_POST['critical']);

    $old_quantity = $product['quantity'];
    $new_quantity = intval($_POST['quantity']);
    $change_amount = $new_quantity - $old_quantity;


    $stmt = $conn->prepare("
        UPDATE products 
        SET name=?, sku=?, quantity=?, price=?, category_id=?, supplier_id=?, critical_level=? 
        WHERE id=?
    ");
    $stmt->bind_param("ssidiiii", $name, $sku, $quantity, $price, $category_id, $supplier_id, $critical, $id);
    $stmt->execute();

    // After updating product
    log_action($conn, $_SESSION['user_id'], 'edit', 'products', $id, "Edited product $name. Quantity change: $change_amount");


    // Log stock movement only if quantity changed
    if ($change_amount != 0) {
        $reason = 'adjust';

        $mov = $conn->prepare("
            INSERT INTO stock_movements (product_id, change_amount, old_quantity, new_quantity, reason, created_by)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $mov->bind_param(
            "iiiisi",
            $id,
            $change_amount,
            $old_quantity,
            $new_quantity,
            $reason,
            $_SESSION['user_id']
        );
        $mov->execute();
    }

    header("Location: list.php?msg=updated");
    exit();
}
?>

<h2>Edit Product</h2>

<form method="POST">
    <label>Product Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br><br>

    <label>SKU:</label><br>
    <input type="text" name="sku" value="<?= htmlspecialchars($product['sku']) ?>" required><br><br>

    <label>Category:</label><br>
    <select name="category" required>
        <option value="">-- Select --</option>
        <?php
        $cats = $conn->query("SELECT * FROM categories");
        while ($c = $cats->fetch_assoc()) {
            $selected = $product['category_id'] == $c['id'] ? "selected" : "";
            echo "<option value='{$c['id']}' $selected>{$c['name']}</option>";
        }
        ?>
    </select><br><br>

    <label>Supplier:</label><br>
    <select name="supplier" required>
        <option value="">-- Select --</option>
        <?php
        $sups = $conn->query("SELECT * FROM suppliers");
        while ($s = $sups->fetch_assoc()) {
            $selected = $product['supplier_id'] == $s['id'] ? "selected" : "";
            echo "<option value='{$s['id']}' $selected>{$s['name']}</option>";
        }
        ?>
    </select><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" value="<?= $product['quantity'] ?>" min="0" required><br><br>

    <label>Price:</label><br>
    <input type="number" name="price" value="<?= $product['price'] ?>" step="0.01"><br><br>

    <label>Critical Level:</label><br>
    <input type="number" name="critical" value="<?= $product['critical_level'] ?? 0 ?>" min="0"><br><br>

    <button type="submit">Save Changes</button>
</form>

<br>
<a href="list.php">Back</a>