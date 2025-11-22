$(document).ready(function () {
    console.log("Inventory System Loaded");

    function loadProducts() {
        var query = $("#search").val();
        var category = $("#filterCategory").val();
        var supplier = $("#filterSupplier").val();

        $.ajax({
            url: "/inventory/ajax/filter_products.php",
            method: "GET",
            data: { q: query, category: category, supplier: supplier },
            success: function (data) {
                $("#product-table table").html(
                    "<tr>" +
                    "<th>ID</th><th>Name</th><th>SKU</th><th>Qty</th><th>Category</th><th>Supplier</th><th>Price</th><th>Actions</th>" +
                    "</tr>" + data
                );
            }
        });
    }

    // Trigger on search keyup
    $("#search").on("keyup", loadProducts);

    // Trigger on filter change
    $("#filterCategory, #filterSupplier").on("change", loadProducts);

    // Trigger on filter form submit (optional)
    $("#filterForm").submit(function (e) {
        e.preventDefault();
        loadProducts();
    });

    // Initial load
    loadProducts();
});
