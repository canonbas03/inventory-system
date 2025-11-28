<?php
include "../../includes/db.php";

if (!$conn) {
    die("DB connection failed");
}

$sql = "SELECT * FROM categories ORDER BY name";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

echo "<option value=''>-- Select --</option>";
while ($c = $result->fetch_assoc()) {
    echo "<option value='{$c['id']}'>{$c['name']}</option>";
}
