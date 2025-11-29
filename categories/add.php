<?php
include "../includes/auth_check.php";
include "../includes/header.php";
?>

<h2>Add Category</h2>

<form id="add-category-form">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <button type="submit">Add Category</button>
</form>

<br><a href="list.php">Back to list</a>

<div id="msg" style="margin-top:10px; font-weight:bold;"></div>

<script>
    $("#add-category-form").on("submit", function(e) {
        e.preventDefault();

        $.post("../api/categories/add_category.php", $(this).serialize(), function(response) {

            if (response.trim() === "OK") {
                $("#msg")
                    .css("color", "green")
                    .text("Category added successfully!");

                setTimeout(() => {
                    window.location.href = "list.php";
                }, 800);

            } else {
                $("#msg")
                    .css("color", "red")
                    .text("Error: " + response);
            }
        });
    });
</script>

<?php include "../includes/footer.php"; ?>