<?php
session_start();
include "../includes/db.php";
include "../includes/audit.php";

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /inventory/auth/login.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($username && $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hash, $role);
        if ($stmt->execute()) {
            $success = "User created successfully!";

            // Log the action
            $admin_username = $_SESSION['username']; // who created the user
            log_action(
                $conn,
                $_SESSION['user_id'],
                'register',
                'users',
                $conn->insert_id,
                "Admin '$admin_username' registered new user '$username' with role '$role'"
            );
        } else {
            $error = "Error: " . $conn->error;
        }
    } else {
        $error = "Please fill in all fields!";
    }
}
?>

<link rel="stylesheet" href="/inventory/assets/css/style.css">
<div class="auth-wrapper">
    <div class="auth-card">
        <h2>Register</h2>

        <?php if ($error): ?>
            <p class="error-msg"><?= $error ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="success-msg"><?= $success ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Role</label>
            <select name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">Create User</button>
        </form>
    </div>

</div>