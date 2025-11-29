<?php
include "../../includes/db.php";

// Get filter values from GET parameters
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$category = isset($_GET['category']) && $_GET['category'] !== '' ? intval($_GET['category']) : null;
$supplier = isset($_GET['supplier']) && $_GET['supplier'] !== '' ? intval($_GET['supplier']) : null;

// Base SQL
$sql = "
    SELECT p.*, c.name AS category, s.name AS supplier
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN suppliers s ON p.supplier_id = s.id
    WHERE 1=1
";

$params = [];
$types = "";

// Search filter
if (!empty($q)) {
    $sql .= " AND (p.name LIKE ? OR p.sku LIKE ? OR c.name LIKE ? OR s.name LIKE ?)";
    $types .= "ssss";
    $searchTerm = "%$q%";
    $params[] = $searchTerm; // product name
    $params[] = $searchTerm; // sku
    $params[] = $searchTerm; // category name
    $params[] = $searchTerm; // supplier name
}


// Category filter
if ($category) {
    $sql .= " AND p.category_id = ?";
    $types .= "i";
    $params[] = $category;
}

// Supplier filter
if ($supplier) {
    $sql .= " AND p.supplier_id = ?";
    $types .= "i";
    $params[] = $supplier;
}

// Prepare statement
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Output table rows
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>" . htmlspecialchars($row['name']) . "</td>
        <td>" . htmlspecialchars($row['sku']) . "</td>
        <td>{$row['quantity']}</td>
        <td>{$row['category']}</td>
        <td>{$row['supplier']}</td>
        <td>{$row['price']}</td>
        <td>
            <a href='#' class='edit-product-btn' data-id ={$row['id']}>Edit</a> |
            <a href='#' class='delete-product-btn' data-id={$row['id']}>Delete</a>
        </td>
    </tr>";
}
