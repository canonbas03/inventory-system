<?php
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

<div id="product-table">
    <table border="1" cellpadding="10">
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
        <!-- Rows will be loaded by AJAX -->
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        function loadProducts() {
            $.ajax({
                url: "../ajax/filter_products.php",
                method: "GET",
                data: {
                    q: $("#search").val(),
                    category: $("#filterCategory").val(),
                    supplier: $("#filterSupplier").val()
                },
                success: function(data) {
                    $("#product-table table").html(
                        "<tr><th>ID</th><th>Name</th><th>SKU</th><th>Qty</th><th>Category</th><th>Supplier</th><th>Price</th><th>Actions</th></tr>" + data
                    );
                }
            });
        }

        // Trigger on search keyup
        $("#search").on("keyup", loadProducts);

        // Trigger on dropdown change
        $("#filterCategory, #filterSupplier").on("change", loadProducts);

        // Initial load
        loadProducts();
    });
</script>

<?php include "../includes/footer.php"; ?>