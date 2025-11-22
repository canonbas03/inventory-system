<?php
include "../includes/db.php";
include "../includes/header.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) die("Invalid category ID");

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$category = $stmt->get_result()->fetch_assoc();

if (!$category) die("Category not found");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $stmt = $conn->prepare("UPDATE categories SET name=? WHERE id=?");
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();
        header("Location: list.php");
        exit;
    } else {
        $error = "Category name cannot be empty.";
    }
}
?>

<h2>Edit Category</h2>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" required><br><br>
    <button type="submit">Save Changes</button>
</form>

<br><a href="list.php">Back to list</a>

<?php include "../includes/footer.php"; ?>