<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/header.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) die("Invalid category ID");

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$category = $stmt->get_result()->fetch_assoc();

if (!$category) die("Category not found");
?>

<h2>Edit Category</h2>

<form id="edit-category-form">
    <input type="hidden" name="id" value="<?= $category['id'] ?>">

    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" required><br><br>

    <button type="submit">Save Changes</button>
</form>

<div id="msg" style="margin-top:10px; font-weight:bold;"></div>

<br><a class='button-link' href="list.php">Back to list</a>

<script>
    $("#edit-category-form").on("submit", function(e) {
        e.preventDefault();

        $.post("../api/categories/edit_category.php", $(this).serialize(), function(response) {

            if (response.trim() === "OK") {
                $("#msg").css("color", "green").text("Category updated successfully!");

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