<?php
include "../includes/db.php";
include "../includes/header.php";  // includes CSS, nav, etc.
?>

<h2>Suppliers</h2>
<a href="add.php">Add Supplier</a><br><br>

<input type="text" id="searchSupplier" placeholder="Search suppliers by name">

<div id="supplier-table">
    <table class="table" border="1" cellpadding="10"> <!-- you can add your custom class -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- rows will be loaded by AJAX -->
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function loadSuppliers() {
            $.ajax({
                url: "../ajax/filter_suppliers.php",
                method: "GET",
                data: {
                    q: $("#searchSupplier").val()
                },
                success: function(data) {
                    $("#supplier-table tbody").html(data); // update tbody only
                }
            });
        }

        $("#searchSupplier").on("keyup", loadSuppliers);

        loadSuppliers(); // initial load
    });
</script>

<?php include "../includes/footer.php"; ?>