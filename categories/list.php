<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/header.php";

?>

<h2>Categories</h2>
<a class='button-link' href="add.php">Add Category</a><br><br>

<form id="filter-category-form" class="filter-form">
    <label>Search:</label>
    <input id="search-category" type="text" placeholder="Search categories by name">
</form>

<div id="category-table">
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <!-- AJAX -->
    </table>
</div>

<?php include "../includes/footer.php"; ?>