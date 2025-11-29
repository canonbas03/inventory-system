<?php
include "../../includes/db.php";

if (!$conn) {
    die("DB connection failed");
}

$sql = "SELECT * FROM suppliers ORDER BY name";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

echo "<option value=''>-- Select --</option>";
while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['id']}'>{$row['name']}</option>";
}
