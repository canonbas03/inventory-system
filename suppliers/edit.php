<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/header.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) die("Invalid supplier ID");

$id = intval($_GET['id']);

$sql = "SELECT * FROM suppliers WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$supplier = $stmt->get_result()->fetch_assoc();

if (!$supplier) die("Supplier not found");
?>

<div class="form-card">
    <h2>Edit Supplier</h2>

    <form id="edit-supplier-form">
        <input type="hidden" name="id" value="<?= $supplier['id'] ?>">

        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($supplier['name']) ?>" required>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($supplier['phone']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($supplier['email']) ?>" required>

        <button class="btn btn-primary" type="submit">Save Changes</button>
    </form>

    <a class="btn btn-secondary" href="list.php">Back to list</a>

    <div id="msg" class="form-msg"></div>
</div>


<script>
    $("#edit-supplier-form").on("submit", function(e) {
        e.preventDefault();

        $.post("../api/suppliers/edit_supplier.php", $(this).serialize(), function(response) {

            if (response.trim() === "OK") {
                $("#msg").css("color", "green").text("Supplier updated successfully!");

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