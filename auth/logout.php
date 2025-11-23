<?php
session_start();
include "../includes/db.php";
include "../includes/audit.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'] ?? 'Unknown';

    log_action($conn, $user_id, 'logout', null, null, "User '$username' logged out");
}

session_destroy();
header("Location: login.php");
exit;
