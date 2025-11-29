<?php
include "../../includes/auth_check.php";
include "../../includes/db.php";

$sql = "
    SELECT p.*, c.name AS category, s.name AS supplier
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN suppliers s ON p.supplier_id = s.id
    WHERE p.quantity <= p.critical_level
    ORDER BY p.quantity ASC
";

$result = $conn->query($sql);
$count = $result->num_rows;

// Start output with count
echo $count . "|||";

if ($count > 0) {

    echo "<table border='1' cellpadding='10'>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Qty</th>
            <th>Critical Level</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>Actions</th>
        </tr>";

    while ($row = $result->fetch_assoc()) {

        $id = $row['id'];
        $name = htmlspecialchars($row['name']);
        $qty = $row['quantity'];
        $crit = $row['critical_level'];
        $cat = $row['category'];
        $sup = $row['supplier'];

        echo "
            <tr style='color:red;'>
                <td>$id</td>
                <td>$name</td>
                <td>$qty</td>
                <td>$crit</td>
                <td>$cat</td>
                <td>$sup</td>
                <td>
                    <a href='#' class='edit-product-btn' data-id='$id'>Edit</a> |
                    <a href='#' class='delete-product-btn' data-id='$id'>Delete</a>
                </td>
            </tr>
        ";
    }

    echo "</table>";
} else {
    echo "<p>All products have sufficient stock.</p>";
}

exit;
