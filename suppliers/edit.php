<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/header.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) die("Invalid supplier ID");

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM suppliers WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$supplier = $stmt->get_result()->fetch_assoc();

if (!$supplier) die("Supplier not found");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if (!empty($name) && !empty($phone) && !empty($email)) {
        $stmt = $conn->prepare("UPDATE suppliers SET name=?, phone=?, email=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $phone, $email, $id);
        $stmt->execute();
        header("Location: list.php");
        exit;
    } else {
        $error = "All fields are required.";
    }
}
?>

<h2>Edit Supplier</h2>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post">
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