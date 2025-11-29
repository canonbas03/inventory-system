<?php
include "includes/auth_check.php";
include "includes/db.php";
include "includes/header.php";

?>

<h2>Inventory Dashboard</h2>

<div style="display:flex; gap:20px; margin-bottom:30px; flex-wrap:wrap;">
    <a href="products/list.php" style="text-decoration:none; color:black;">
        <div style="flex:1; padding:20px; border:1px solid #ccc; border-radius:10px; text-align:center; background:#f0f8ff;">
            <h3>Total Products</h3>
            <p id="total-products" style="font-size:24px;">...</p>
        </div>
    </a>

    <a href="categories/list.php" style="text-decoration:none; color:black;">
        <div style="flex:1; padding:20px; border:1px solid #ccc; border-radius:10px; text-align:center; background:#f9f0ff;">
            <h3>Total Categories</h3>
            <p id="total-categories" style="font-size:24px;">...</p>
        </div>
    </a>

    <a href="suppliers/list.php" style="text-decoration:none; color:black;">
        <div style="flex:1; padding:20px; border:1px solid #ccc; border-radius:10px; text-align:center; background:#fff0f0;">
            <h3>Total Suppliers</h3>
            <p id="total-suppliers" style="font-size:24px;">...</p>
        </div>
    </a>

    <a href="products/list.php" style="text-decoration:none; color:black;">
        <div style="flex:1; padding:20px; border:1px solid #ccc; border-radius:10px; text-align:center; background:#fffbe0;">
            <h3>Low Stock Products</h3>
            <p id="low-stock-count" style="font-size:24px; color:red;">...</p>
        </div>
    </a>
</div>

<h3>Low Stock Products Details</h3>

<div id="low-stock-table">Loading...</div>

<?php include "includes/footer.php"; ?>