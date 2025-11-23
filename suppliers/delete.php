<?php
include "../includes/auth_check.php";
include "../includes/db.php";
include "../includes/audit.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) die("Invalid supplier ID");

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT name FROM suppliers WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$supplier = $result->fetch_assoc();

if (!$supplier) die("Category not found");

$supplier_name = $supplier['name'];

// Delete category
$stmt = $conn->prepare("DELETE FROM suppliers WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    log_action(
        $conn,
        $_SESSION['user_id'],
        'delete',
        'suppliers',
        $id,
        "User '{$_SESSION['username']}' deleted supplier '$supplier_name'"
    );

    header("Location: list.php");
    exit;
} else {
    echo "Error deleting supplier: " . $conn->error;
}
