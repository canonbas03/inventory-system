<?php
include "includes/db.php";
include "includes/header.php";

// Total counts
$total_products = $conn->query("SELECT COUNT(*) AS cnt FROM products")->fetch_assoc()['cnt'];
$total_categories = $conn->query("SELECT COUNT(*) AS cnt FROM categories")->fetch_assoc()['cnt'];
$total_suppliers = $conn->query("SELECT COUNT(*) AS cnt FROM suppliers")->fetch_assoc()['cnt'];

// Low stock products
$low_stock = $conn->query("
    SELECT p.*, c.name AS category, s.name AS supplier
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN suppliers s ON p.supplier_id = s.id
    WHERE p.quantity <= p.critical_level
    ORDER BY p.quantity ASC
");
?>

<h2>Inventory Dashboard</h2>

<div style="display:flex; gap:20px; margin-bottom:30px; flex-wrap:wrap;">
    <a href="products/list.php" style="text-decoration:none; color:black;">
        <div style="flex:1; padding:20px; border:1px solid #ccc; border-radius:10px; text-align:center; background:#f0f8ff;">
            <h3>Total Products</h3>
            <p style="font-size:24px;"><?= $total_products ?></p>
        </div>
    </a>

    <a href="categories/list.php" style="text-decoration:none; color:black;">
        <div style="flex:1; padding:20px; border:1px solid #ccc; border-radius:10px; text-align:center; background:#f9f0ff;">
            <h3>Total Categories</h3>
            <p style="font-size:24px;"><?= $total_categories ?></p>
        </div>
    </a>

    <a href="suppliers/list.php" style="text-decoration:none; color:black;">
        <div style="flex:1; padding:20px; border:1px solid #ccc; border-radius:10px; text-align:center; background:#fff0f0;">
            <h3>Total Suppliers</h3>
            <p style="font-size:24px;"><?= $total_suppliers ?></p>
        </div>
    </a>

    <a href="products/list.php" style="text-decoration:none; color:black;">
        <div style="flex:1; padding:20px; border:1px solid #ccc; border-radius:10px; text-align:center; background:#fffbe0;">
            <h3>Low Stock Products</h3>
            <p style="font-size:24px; color:red;"><?= $low_stock->num_rows ?></p>
        </div>
    </a>
</div>

<h3>Low Stock Products Details</h3>
<?php if ($low_stock->num_rows > 0): ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Qty</th>
            <th>Critical Level</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $low_stock->fetch_assoc()): ?>
            <tr style="color:red;">
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['critical_level'] ?></td>
                <td><?= $row['category'] ?></td>
                <td><?= $row['supplier'] ?></td>
                <td>
                    <a href="products/edit.php?id=<?= $row['id'] ?>">Edit</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>All products have sufficient stock.</p>
<?php endif; ?>

<?php include "includes/footer.php"; ?>