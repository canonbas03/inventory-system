<?php
include "../includes/db.php";
include "../includes/header.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $sku = trim($_POST["sku"]);
    $quantity = intval($_POST["quantity"]);
    $price = floatval($_POST["price"]);
    $category_id = intval($_POST["category"]);
    $supplier_id = intval($_POST["supplier"]);
    $critical = intval($_POST["critical"]);

    if (!empty($name) && !empty($sku) && $category_id && $supplier_id) {

        $stmt = $conn->prepare("
            INSERT INTO products (name, sku, quantity, price, category_id, supplier_id, critical_level)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssidiii", $name, $sku, $quantity, $price, $category_id, $supplier_id, $critical);

        if ($stmt->execute()) {
            echo "<script>alert('Product added successfully!'); 
                  window.location='list.php';</script>";
            exit;
        } else {
            echo "<p style='color:red;'>Error adding product: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Name, SKU, category, and supplier are required!</p>";
    }
}
?>

<h2>Add Product</h2>

<form method="post">

    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>SKU (unique code):</label><br>
    <input type="text" name="sku" required><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" value="0" min="0"><br><br>

    <label>Price:</label><br>
    <input type="number" step="0.01" name="price" value="0.00"><br><br>

    <label>Category:</label><br>
    <select name="category" required>
        <option value="">-- Select --</option>
        <?php
        $cats = $conn->query("SELECT * FROM categories");
        while ($c = $cats->fetch_assoc()) {
            echo "<option value='{$c['id']}'>{$c['name']}</option>";
        }
        ?>
    </select><br><br>

    <label>Supplier:</label><br>
    <select name="supplier" required>
        <option value="">-- Select --</option>
        <?php
        $sups = $conn->query("SELECT * FROM suppliers");
        while ($s = $sups->fetch_assoc()) {
            echo "<option value='{$s['id']}'>{$s['name']}</option>";
        }
        ?>
    </select><br><br>

    <label>Critical Level:</label><br>
    <input type="number" name="critical" value="0" min="0"><br><br>

    <button type="submit">Add Product</button>
</form>

<?php include "../includes/footer.php"; ?>