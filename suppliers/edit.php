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

<h2>Edit Supplier</h2>

<form id="edit-supplier-form">
    <input type="hidden" name="id" value="<?= $supplier['id'] ?>">

    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($supplier['name']) ?>" required><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" value="<?= htmlspecialchars($supplier['phone']) ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($supplier['email']) ?>" required><br><br>

    <button type="submit">Save Changes</button>
</form>

<br><a href="list.php">Back to list</a>

<?php include "../includes/footer.php"; ?>