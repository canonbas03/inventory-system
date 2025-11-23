<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/header.php";
include "../includes/audit.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if (!empty($name) && !empty($phone) && !empty($email)) {
        $stmt = $conn->prepare("INSERT INTO suppliers (name, phone, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $phone, $email);
        if ($stmt->execute()) {

            log_action(
                $conn,
                $_SESSION['user_id'],
                'add',
                'suppliers',
                $conn->insert_id,
                "User '{$_SESSION['username']}' added supplier '$name'"
            );

            header("Location: list.php");
            exit;
        } else {
            $error = "Error adding supplier: " . $conn->error;
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<h2>Add Supplier</h2>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <button type="submit">Add Supplier</button>
</form>

<br><a href="list.php">Back to list</a>

<?php include "../includes/footer.php"; ?>