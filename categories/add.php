<?php

include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/header.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);

    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            header("Location: list.php");
            exit;
        } else {
            $error = "Error adding category: " . $conn->error;
        }
    } else {
        $error = "Category name cannot be empty.";
    }
}
?>

<h2>Add Category</h2>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>
    <button type="submit">Add Category</button>
</form>

<br><a href="list.php">Back to list</a>

<?php include "../includes/footer.php"; ?>