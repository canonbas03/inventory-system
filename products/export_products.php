<?php
include "../includes/db.php";
include "../includes/auth_check.php";
include "../includes/audit.php";

// Optional: you can filter export by category/supplier via GET parameters
$category = isset($_GET['category']) && $_GET['category'] !== '' ? intval($_GET['category']) : null;
$supplier = isset($_GET['supplier']) && $_GET['supplier'] !== '' ? intval($_GET['supplier']) : null;

// Set headers so browser downloads file
$timestamp = date('Ymd_His');

// Set headers with dynamic filename
header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=\"products_{$timestamp}.csv\"");

// Open output stream
$output = fopen('php://output', 'w');

// CSV header row
fputcsv($output, ['ID', 'Name', 'SKU', 'Quantity', 'Category', 'Supplier', 'Price']);

// Build query
$sql = "
    SELECT p.id, p.name, p.sku, p.quantity, c.name AS category, s.name AS supplier, p.price
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN suppliers s ON p.supplier_id = s.id
    WHERE 1=1
";

$params = [];
$types = "";

// Apply optional filters
if ($category) {
    $sql .= " AND p.category_id = ?";
    $types .= "i";
    $params[] = $category;
}

if ($supplier) {
    $sql .= " AND p.supplier_id = ?";
    $types .= "i";
    $params[] = $supplier;
}

// Prepare and execute
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Output rows
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);

log_action($conn, $_SESSION['user_id'], 'export', 'products', null, "Exported products CSV");

exit;
