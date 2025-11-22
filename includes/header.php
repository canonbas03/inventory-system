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

    <link rel="stylesheet" href="/inventory/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/inventory/assets/js/main.js"></script>
</head>

<body>

    <nav>
        <ul>
            <li><a href="/inventory/index.php">Dashboard</a></li>
            <li><a href="/inventory/products/list.php">Products</a></li>
            <li><a href="/inventory/categories/list.php">Categories</a></li>
            <li><a href="/inventory/suppliers/list.php">Suppliers</a></li>
            <?php if (isset($_SESSION['username'])): ?>
                <p>Welcome, <?= $_SESSION['username'] ?> | <a href="../logout.php">Logout</a></p>
            <?php else: ?>
                <a href="../login.php">Login</a>
            <?php endif; ?>

        </ul>
    </nav>

    <div class="container">