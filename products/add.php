<?php
include "../includes/header.php";
include "../includes/auth_check.php";
?>

<div class="form-card">
    <h2>Add Product</h2>

    <form id="add-product-form">

        <label>Name:</label>
        <input type="text" name="name" required>

        <label>SKU (unique code):</label>
        <input type="text" name="sku" required>

        <label>Quantity:</label>
        <input type="number" name="quantity" value="0" min="0">

        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="0.00">

        <label>Category:</label>
        <select id="category-select" name="category" required>
            <option value="">-- Select --</option>
        </select>

        <label>Supplier:</label>
        <select id="supplier-select" name="supplier" required>
            <option value="">-- Select --</option>
        </select>

        <label>Critical Level:</label>
        <input type="number" name="critical" value="0" min="0">

        <button class="btn btn-primary" type="submit">Add Product</button>

    </form>

    <div id="msg" class="form-msg"></div>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $("#add-product-form").on("submit", function(e) {
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