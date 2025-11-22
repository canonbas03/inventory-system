<?php
include "../includes/db.php";
include "../includes/header.php";
?>

<h2>Products</h2>
<a href="add.php">Add Product</a><br><br>

<label>Search:</label>
<input type="text" id="search" placeholder="Search by name, SKU, category, or supplier">

<div id="product-table">
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>SKU</th>
            <th>Qty</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>

        <?php
        $result = $conn->query("
    SELECT products.*, categories.name AS category, suppliers.name AS supplier
    FROM products
    LEFT JOIN categories ON products.category_id = categories.id
    LEFT JOIN suppliers ON products.supplier_id = suppliers.id
");
        while ($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['sku']) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['category'] ?></td>
                <td><?= $row['supplier'] ?></td>
                <td><?= $row['price'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#search").on("keyup", function() {
            var query = $(this).val();

            $.ajax({
                url: "../ajax/search_products.php",
                method: "GET",
                data: {
                    q: query
                },
                success: function(data) {
                    $("#product-table table").html(
                        "<tr>" +
                        "<th>ID</th><th>Name</th><th>SKU</th><th>Qty</th><th>Category</th><th>Supplier</th><th>Price</th><th>Actions</th>" +
                        "</tr>" + data
                    );
                }
            });
        });
    });
</script>

<?php include "../includes/footer.php"; ?>