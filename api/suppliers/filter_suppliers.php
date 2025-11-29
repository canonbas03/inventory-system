<?php
include "../../includes/db.php";

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$sql = "SELECT * FROM suppliers WHERE 1=1";
$params = [];
$types = "";

if (!empty($q)) {
    $sql .= " AND name LIKE ?";
    $types .= "s";
    $params[] = "%$q%";
}

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>" . htmlspecialchars($row['name']) . "</td>
        <td>" . htmlspecialchars($row['phone']) . "</td>
        <td>" . htmlspecialchars($row['email']) . "</td>
        <td>
            <a href='#' class='edit-supplier-btn' data-id ={$row['id']}>Edit</a> |
            <a href='#' class='delete-supplier-btn' data-id={$row['id']}>Delete</a>

        </td>
    </tr>";
}
