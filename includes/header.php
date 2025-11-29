<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$basePath = "/inventory"; // adjust if project folder changes
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Inventory System</title>

    <link rel="stylesheet" href="<?= $basePath ?>/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?= $basePath ?>/assets/js/main.js"></script>
</head>

<body>
    <nav>
        <ul>
            <li><a href="<?= $basePath ?>/index.php">Dashboard</a></li>
            <li><a href="<?= $basePath ?>/products/list.php">Products</a></li>
            <li><a href="<?= $basePath ?>/categories/list.php">Categories</a></li>
            <li><a href="<?= $basePath ?>/suppliers/list.php">Suppliers</a></li>

            <?php if (isset($_SESSION['username'])): ?>
                <li style="float:right;">
                    Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> |
                    <a href="<?= $basePath ?>/auth/logout.php">Logout</a>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        | <a href="<?= $basePath ?>/auth/register.php">Register User</a>
                        | <a href="<?= $basePath ?>/audit/list.php">Logs</a>

                    <?php endif; ?>
                </li>
            <?php else: ?>
                <li style="float:right;"><a class='button-link' href="<?= $basePath ?>/auth/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="container">