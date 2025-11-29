<?php
include "../includes/auth_check.php";
include "../includes/header.php";
?>

<h2>Add Supplier</h2>

<!-- <!php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?> -->

<form id="add-supplier-form">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <button type="submit">Add Supplier</button>
</form>

<br><a href="list.php">Back to list</a>

<div id="msg" style="margin-top:10px; font-weight:bold;"></div>

<script>
    $("#add-supplier-form").on("submit", function(e) {
        e.preventDefault();

        $.post("../api/suppliers/add_supplier.php", $(this).serialize(), function(response) {

            if (response.trim() === "OK") {
                $("#msg").css("color", "green").text("Product added successfully!");

                setTimeout(() => {
                    window.location.href = "list.php";
                }, 800);
            } else {
                $("#msg").css("color", "red").text("Errorbaby: " + response);
            }
        });
    });
</script>

<?php include "../includes/footer.php"; ?>