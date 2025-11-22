<?php
include "../includes/db.php";
include "../includes/header.php";

$result = $conn->query("SELECT products.*, categories.name AS category
    FROM products
    LEFT JOIN categories ON products.category_id = categories.id
");
?>

<h2>Products</h2>
<a href="add.php">Add Product</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>SKU</th>
        <th>Qty</th>
        <th>Category</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['sku']) ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['category'] ?></td>
            <td><?= $row['price'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                |
                <a href="delete.php?id=<?= $row['id'] ?>"
                    onclick="return confirm('Delete this product?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php include "../includes/footer.php"; ?>