<?php
include "../includes/db.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) die("Invalid supplier ID");

$id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM suppliers WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: list.php");
    exit;
} else {
    echo "Error deleting supplier: " . $conn->error;
}
