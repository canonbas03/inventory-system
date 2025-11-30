<?php
include "../../includes/db.php";
include "../../includes/auth_check.php";
include "../../includes/audit.php";

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$timestamp = date('Ymd_His');
header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=\"audit_{$timestamp}.csv\"");

$output = fopen('php://output', 'w');

// CSV header
fputcsv($output, ['ID', 'User', 'Action', 'Table', 'Row ID', 'Description', 'Date']);

// Updated query to match your table and columns
$sql = "SELECT a.*, u.username 
        FROM audit_log a 
        JOIN users u ON a.user_id = u.id
        WHERE 1=1";

$params = [];
$types = "";

if ($q) {
    $sql .= " AND (u.username LIKE ? OR a.action LIKE ? OR a.target_table LIKE ? OR a.details LIKE ?)";
    $search = "%$q%";
    $types .= "ssss";
    $params = [$search, $search, $search, $search];
}

$sql .= " ORDER BY a.id DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Output CSV rows
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['id'],
        $row['username'],
        $row['action'],
        $row['target_table'],
        $row['target_id'],
        $row['details'],
        $row['created_at']
    ]);
}

fclose($output);

// Log export action
log_action($conn, $_SESSION['user_id'], 'export', 'audit', null, 'Exported audit CSV');
exit;
