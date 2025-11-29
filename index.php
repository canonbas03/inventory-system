<?php
include "includes/auth_check.php";
include "includes/db.php";
include "includes/header.php";

?>

<h2>Inventory Dashboard</h2>

<div class="dashboard-cards">
    <a href="products/list.php">
        <div class="dashboard-card card-products">
            <h3>Total Products</h3>
            <p id="total-products">...</p>
        </div>
    </a>

    <a href="categories/list.php">
        <div class="dashboard-card card-categories">
            <h3>Total Categories</h3>
            <p id="total-categories">...</p>
        </div>
    </a>

    <a href="suppliers/list.php">
        <div class="dashboard-card card-suppliers">
            <h3>Total Suppliers</h3>
            <p id="total-suppliers">...</p>
        </div>
    </a>

    <a href="products/list.php">
        <div class="dashboard-card card-lowstock">
            <h3>Low Stock Products</h3>
            <p id="low-stock-count">...</p>
        </div>
    </a>
</div>


<h3>Low Stock Products Details</h3>

<div id="low-stock-table">Loading...</div>

<?php include "includes/footer.php"; ?>