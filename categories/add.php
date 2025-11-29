<?php
include "../includes/auth_check.php";
include "../includes/header.php";
?>

<div class="form-card">
    <h2>Add Category</h2>

    <form id="add-category-form">
        <label>Name:</label>
        <input type="text" name="name" required>

        <button class="btn btn-primary" type="submit">Add Category</button>
    </form>

    <a class="btn btn-secondary" href="list.php">Back to list</a>

    <div id="msg" class="form-msg"></div>
</div>

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