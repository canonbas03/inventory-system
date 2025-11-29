<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/header.php";
?>

<h2>Suppliers</h2>
<a href="add.php">Add Supplier</a><br><br>

<input type="text" id="searchSupplier" placeholder="Search suppliers by name">

<div id="supplier-table">
    <table class="table" border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- AJAX -->
        </tbody>
    </table>
</div>

<?php include "../includes/footer.php"; ?>