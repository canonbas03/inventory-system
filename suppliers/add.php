<?php
include "../includes/auth_check.php";
include "../includes/header.php";
?>

<h2>Add Supplier</h2>

<div class="form-card">
    <h2>Add Supplier</h2>

    <form id="add-supplier-form">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Phone:</label>
        <input type="text" name="phone" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <button class="btn btn-primary" type="submit">Add Supplier</button>
    </form>

    <a class="btn btn-secondary" href="list.php">Back to list</a>

    <div id="msg" class="form-msg"></div>
</div>


<script>
    $("#add-supplier-form").on("submit", function(e) {
        e.preventDefault();

        $.post("../api/suppliers/add_supplier.php", $(this).serialize(), function(response) {

            if (response.trim() === "OK") {
                $("#msg").css("color", "green").text("Supplier added successfully!");

                setTimeout(() => {
                    window.location.href = "list.php";
                }, 800);
            } else {
                $("#msg").css("color", "red").text("Error: " + response);
            }
        });
    });
</script>

<?php include "../includes/footer.php"; ?>