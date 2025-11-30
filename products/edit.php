<?php
include "../includes/db.php";
include "../includes/header.php";
include "../includes/auth_check.php";


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM products WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) die("Product not found");
?>

<div class="form-card">
    <h2>Edit Product</h2>

    <form id="edit-product-form">

        <input type="hidden" name="id" value="<?= $product['id'] ?>">

        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

        <label>Price:</label>
        <input type="number" name="price" value="<?= $product['price'] ?>" step="0.01" required>

        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?= $product['quantity'] ?>" min="0" required>

        <button class="btn btn-primary" type="submit">Save Changes</button>
    </form>

    <a class="btn btn-secondary" href="list.php">Back to list</a>

    <div id="msg" class="form-msg"></div>
</div>


<script>
    $("#edit-product-form").on("submit", function(e) {
        e.preventDefault();

        $.post("../api/products/edit_product.php", $(this).serialize(), function(response) {

            if (response.trim() === "OK") {
                $("#msg").css("color", "green").text("Product updated successfully!");

                setTimeout(() => {
                    window.location.href = "list.php";
                }, 800);
            } else {
                $("#msg").css("color", "red").text("Error: " + response);
            }
        });
    });
</script>


<?php require_once "../includes/footer.php"; ?>