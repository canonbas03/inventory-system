<?php
include "../../includes/db.php";
include "../../includes/auth_check.php";

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

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

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['username']}</td>
        <td>{$row['action']}</td>
        <td>{$row['target_table']}</td>
        <td>{$row['target_id']}</td>
        <td>{$row['details']}</td>
        <td>{$row['created_at']}</td>
    </tr>";
}
