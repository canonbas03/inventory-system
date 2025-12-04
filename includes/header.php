<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Inventory System</title>

    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/assets/js/main.js"></script>
</head>

<body>
    <nav>
        <ul>
            <li><a href="/index.php">Dashboard</a></li>
            <li><a href="/products/list.php">Products</a></li>
            <li><a href="/categories/list.php">Categories</a></li>
            <li><a href="/suppliers/list.php">Suppliers</a></li>

            <?php if (isset($_SESSION['username'])): ?>
                <li class="user-info">
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        🛠️Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> |
                        <a href="/auth/logout.php">Logout</a>
                        | <a href="/auth/register.php">Register User</a>
                        | <a href="/audit/list.php">Logs</a>
                    <?php else: ?>
                        Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> |
                        <a href="/auth/logout.php">Logout</a>
                    <?php endif; ?>
                </li>
            <?php else: ?>
                <li class="user-info"><a class='button-link' href="/auth/login.php">Login</a></li>
            <?php endif; ?>

        </ul>
    </nav>

    <div class="container">