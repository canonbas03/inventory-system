<?php
include "../includes/db.php";
include "../includes/header.php";
?>

<h2>Categories</h2>
<a href="add.php">Add Category</a><br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Actions</th>
    </tr>

    <?php
    $result = $conn->query("SELECT * FROM categories ORDER BY id ASC");
    while ($row = $result->fetch_assoc()):
    ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this category?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php include "../includes/footer.php"; ?>