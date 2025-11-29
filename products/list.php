<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/header.php";
?>

<h2>Products</h2>
<a href="add.php">Add Product</a><br><br>

<form id="filterForm">
    <label>Search:</label>
    <input type="text" name="q" id="search" placeholder="Search by name, SKU, category, or supplier">

    <label>Category:</label>
    <select name="category" id="filterCategory">
        <option value="">All Categories</option>
        <?php
        $cats = $conn->query("SELECT * FROM categories");
        while ($c = $cats->fetch_assoc()) {
            echo "<option value='{$c['id']}'>{$c['name']}</option>";
        }
        ?>
    </select>

    <label>Supplier:</label>
    <select name="supplier" id="filterSupplier">
        <option value="">All Suppliers</option>
        <?php
        $sups = $conn->query("SELECT * FROM suppliers");
        while ($s = $sups->fetch_assoc()) {
            echo "<option value='{$s['id']}'>{$s['name']}</option>";
        }
        ?>
    </select>
</form>

<a href="export_products.php" class="btn">Export CSV</a>
<a href="export_products.php?category=2&supplier=5" class="btn">Export Filtered CSV</a>


<div id="product-table">
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>SKU</th>
                <th>Qty</th>
                <th>Category</th>
                <th>Supplier</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- AJAX -->
        </tbody>
    </table>
</div>

<?php include "../includes/footer.php"; ?>