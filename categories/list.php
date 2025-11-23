<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/header.php";

?>

<h2>Categories</h2>
<a href="add.php">Add Category</a><br><br>

<input type="text" id="searchCategory" placeholder="Search categories by name">

<div id="category-table">
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <!-- rows will be loaded by AJAX -->
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function loadCategories() {
            $.ajax({
                url: "../ajax/filter_categories.php",
                method: "GET",
                data: {
                    q: $("#searchCategory").val()
                },
                success: function(data) {
                    $("#category-table table").html(
                        "<tr><th>ID</th><th>Name</th><th>Actions</th></tr>" + data
                    );
                }
            });
        }

        $("#searchCategory").on("keyup", loadCategories);

        loadCategories(); // initial load
    });
</script>

<?php include "../includes/footer.php"; ?>