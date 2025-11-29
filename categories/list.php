<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/header.php";

?>

<h2>Categories</h2>
<a href="add.php">Add Category</a><br><br>

<input id="search-category" type="text" placeholder="Search categories by name">

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