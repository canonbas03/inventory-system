<?php
include "../includes/db.php";
include "../includes/header.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $sku = $_POST["sku"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $supplier = $_POST["supplier"];

    if (!empty($name) && !empty($sku)) {

        $stmt = $conn->prepare("
            INSERT INTO products (name, sku, quantity, price, category_id, supplier_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssidii", $name, $sku, $quantity, $price, $category, $supplier);

        if ($stmt->execute()) {
            echo "<script>alert('Product added successfully!'); 
                  window.location='list.php';</script>";
            exit;
        } else {
            echo "<p style='color:red;'>Error adding product: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Name and SKU are required!</p>";
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
    <input type="number" name="quantity" value="0"><br><br>

    <label>Price:</label><br>
    <input type="number" step="0.01" name="price"><br><br>

    <label>Category:</label><br>
    <select name="category">
        <option value="">-- Select --</option>
        <?php
        $cats = $conn->query("SELECT * FROM categories");
        while ($c = $cats->fetch_assoc()) {
            echo "<option value='{$c['id']}'>{$c['name']}</option>";
        }
        ?>
    </select><br><br>

    <label>Supplier:</label><br>
    <select name="supplier">
        <option value="">-- Select --</option>
        <?php
        $sups = $conn->query("SELECT * FROM suppliers");
        while ($s = $sups->fetch_assoc()) {
            echo "<option value='{$s['id']}'>{$s['name']}</option>";
        }
        ?>
    </select><br><br>

    <button type="submit">Add Product</button>
</form>

<?php include "../includes/footer.php"; ?>