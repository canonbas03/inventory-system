<?php
session_start();
include "../includes/db.php";
include "../includes/audit.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        log_action($conn, $user['id'], 'login', null, null, "User '$username' logged in");

        header("Location: ../index.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<link rel="stylesheet" href="/inventory/assets/css/style.css">
<div class="auth-wrapper">
    <div class="auth-card">
        <h2>Login</h2>

        <?php if ($error): ?>
            <p class="error-msg"><?= $error ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>

</div>