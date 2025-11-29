$(document).ready(function () {

   

    function loadProducts() {
        var query = $("#search").val();                // search text
        var category = $("#filterCategory").val();     // selected category
        var supplier = $("#filterSupplier").val();     // selected supplier

        $.ajax({
            url: "../api/filter_products.php",        // unified endpoint
            method: "GET",
            data: {
                q: query,
                category: category,
                supplier: supplier
            },
            success: function (data) {
                $("#product-table table").html(
                    "<tr>" +
                    "<th>ID</th><th>Name</th><th>SKU</th><th>Qty</th><th>Category</th><th>Supplier</th><th>Price</th><th>Actions</th>" +
                    "</tr>" + data
                );
            }
        });
    }

    // Trigger on search input
    $("#search").on("keyup", loadProducts);

    // Trigger on dropdown change
    $("#filterCategory, #filterSupplier").on("change", loadProducts);

    // Initial load
    loadProducts();

    $("#category-select").load("/inventory/api/categories/get_categories.php");
    $("#supplier-select").load("/inventory/api/categories/get_suppliers.php");

    // PRODUCTS

    // Delete products
     $(document).on("click", ".delete-btn", function (e) {
    e.preventDefault();

    if (!confirm("Delete this product?")) return;

    let id = $(this).data("id");

    $.post("/inventory/api/products/delete_product.php", { id: id }, function (response) {
        loadProducts();
         });
    });
});
