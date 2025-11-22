<?php
require_once "db.php";

// 1. Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$id = intval($_GET['id']);

// 2. Load the product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

// 3. Handle FORM SUBMIT
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $category = trim($_POST["category"]);
    $quantity = intval($_POST["quantity"]);
    $critical = intval($_POST["critical"]);

    if ($name === "" || $category === "") {
        $error = "Name and category cannot be empty.";
    } else {
        $update = $conn->prepare(
            "UPDATE products SET name=?, category=?, quantity=?, critical_level=? WHERE id=?"
        );
        $update->bind_param("ssiii", $name, $category, $quantity, $critical, $id);
        $update->execute();

        header("Location: index.php?msg=updated");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
</head>

<body>

    <h2>Edit Product</h2>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">
        <label>Product Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br><br>

        <label>Category:</label><br>
        <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" required><br><br>

        <label>Quantity:</label><br>
        <input type="number" name="quantity" value="<?= $product['quantity'] ?>" min="0" required><br><br>

        <label>Critical Level:</label><br>
        <input type="number" name="critical" value="<?= $product['critical_level'] ?>" min="0" required><br><br>

        <button type="submit">Save Changes</button>
    </form>

    <br>
    <a href="index.php">Back</a>

</body>

</html>