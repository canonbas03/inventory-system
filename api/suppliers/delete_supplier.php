<?php
include "../../includes/auth_check.php";
include "../../includes/db.php";
include "../../includes/audit.php";


if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die("Invalid supplier ID.");
}

$id = intval($_POST['id']);


// audit log
$stmt = $conn->prepare("SELECT name FROM suppliers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$supplier = $result->fetch_assoc();

if (!$supplier) {
    die("Product not found.");
}

$name = $supplier['name'];

$sql = "DELETE FROM suppliers WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    log_action($conn, $_SESSION['user_id'], 'delete', 'suppliers', $id, "Deleted supplier $name");

    exit();
} else {
    echo "Error deleting supplier: " . $conn->error;
}
