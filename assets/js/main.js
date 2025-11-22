$(document).ready(function () {
    console.log("Inventory System Loaded");
});

$(document).ready(function () {
    $("#search").on("keyup", function () {
        var query = $(this).val();

        $.ajax({
            url: "/inventory/ajax/search_products.php",
            method: "GET",
            data: { q: query },
            success: function (data) {
                $("#product-table table").html(
                    "<tr>" +
                    "<th>ID</th><th>Name</th><th>SKU</th><th>Qty</th><th>Category</th><th>Supplier</th><th>Price</th><th>Actions</th>" +
                    "</tr>" + data
                );
            }
        });
    });
});
