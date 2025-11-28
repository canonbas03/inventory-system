<?php
include "../includes/db.php";

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$sql = "SELECT * FROM categories WHERE 1=1";
$params = [];
$types = "";

if (!empty($q)) {
    $sql .= " AND name LIKE ?";
    $types .= "s";
    $params[] = "%$q%";
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>" . htmlspecialchars($row['name']) . "</td>
        <td>
            <a href='edit.php?id={$row['id']}'>Edit</a> |
            <a href='delete.php?id={$row['id']}' onclick='return confirm(\"Delete this category?\")'>Delete</a>
        </td>
    </tr>";
}
