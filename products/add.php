<?php
include "../includes/db.php";
include "../includes/header.php";
include "../includes/audit.php";
include "../includes/auth_check.php";


?>

<h2>Add Product</h2>

<form id="addForm">

    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>SKU (unique code):</label><br>
    <input type="text" name="sku" required><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" value="0" min="0"><br><br>

    <label>Price:</label><br>
    <input type="number" step="0.01" name="price" value="0.00"><br><br>

    <label>Category:</label><br>
    <select id="category-select" name="category" required>
        <option value="">-- Select --</option>
    </select><br><br>

    <label>Supplier:</label><br>
    <select id="supplier-select" name="supplier" required>
        <option value="">-- Select --</option>

        <!-- add id -->
    </select><br><br>

    <label>Critical Level:</label><br>
    <input type="number" name="critical" value="0" min="0"><br><br>

    <button type="submit">Add Product</button>
</form>

<div id="msg" style="margin-top:10px; font-weight:bold;"></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $("#addForm").on("submit", function(e) {
        e.preventDefault();

        $.post("../api/products/add_product.php", $(this).serialize(), function(response) {

            if (response.trim() === "OK") {
                $("#msg").css("color", "green").text("Product added successfully!");

                setTimeout(() => {
                    window.location.href = "list.php";
                }, 800);
            } else {
                $("#msg").css("color", "red").text("Error: " + response);
            }
        });
    });
</script>

<?php include "../includes/footer.php"; ?>