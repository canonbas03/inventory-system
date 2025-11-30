<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/header.php";
?>

<h2>Products</h2>
<a class='button-link' href="add.php">Add Product</a><br><br>

<form id="filter-form" class="filter-form">
    <label>Search:</label>
    <input type="text" name="q" id="search" placeholder="Search by name, SKU, category, or supplier">

    <label>Category:</label>
    <select id="filter-category" name="category">
        <option value="">All Categories</option>
    </select>


    <label>Supplier:</label>
    <select id="filter-supplier" name="supplier">
        <option value="">All Suppliers</option>
    </select>

    <a href="#" id="export-csv" class="button-link">Export CSV</a>

</form>


<a class='button-link' href="export_products.php" class="btn">Export CSV old</a>
<a class='button-link' href="export_products.php?category=2&supplier=5" class="btn">Export Filtered CSV</a>


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

<div id="qty-modal" class="modal">
    <div class="modal-content">
        <h3 id="qty-modal-title">Adjust Quantity</h3>

        <label>Amount:</label>
        <input type="number" id="qty-amount" min="1" value="1">

        <div class="modal-actions">
            <button id="qty-increase" class="button-link edit">Increase</button>
            <button id="qty-decrease" class="button-link delete">Decrease</button>
        </div>
        <br>
        <button id="qty-close" class="button-link">Close</button>
    </div>
</div>



<?php include "../includes/footer.php"; ?>