$(document).ready(function () {

    // Trigger on search input
    
    
    $("#category-select").load("/inventory/api/categories/get_categories.php");
    $("#supplier-select").load("/inventory/api/categories/get_suppliers.php");
    
    
    // === PRODUCTS === \\
    loadProducts();
    function loadProducts() {
        var query = $("#search").val();                // search text
        var category = $("#filterCategory").val();     // selected category
        var supplier = $("#filterSupplier").val();     // selected supplier

        $.ajax({
            url: "../api/products/filter_products.php",        // unified endpoint
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

    // Search
    $("#search").on("keyup", loadProducts);
    $("#filterCategory, #filterSupplier").on("change", loadProducts);

    // Edit products
     $(document).on("click", ".edit-btn", function (e) {
    e.preventDefault();

    let id = $(this).data("id");

    window.location.href = "../products/edit.php?id=" + id;
    });

    // Delete products
     $(document).on("click", ".delete-product-btn", function (e) {
    e.preventDefault();

    if (!confirm("Delete this product?")) return;

    let id = $(this).data("id");

    $.post("/inventory/api/products/delete_product.php", { id: id }, function (response) {
        loadProducts();
         });
    });


    // === SUPPLIERS === \\
    
     loadSuppliers();
     function loadSuppliers() {
             $.ajax({
                    url: "../api/suppliers/filter_suppliers.php",
                    method: "GET",
                    data: {
                        q: $("#searchSupplier").val()
                    },
                    success: function(data) {
                        $("#supplier-table tbody").html(data); // update tbody only
                    }
                 });
                
    }

    // Search
        $("#searchSupplier").on("keyup", loadSuppliers);
    // Delete supplier
     $(document).on("click", ".delete-supplier-btn", function (e) {
    e.preventDefault();

    if (!confirm("Delete this supplier?")) return;

    let id = $(this).data("id");

    $.post("/inventory/api/suppliers/delete_supplier.php", { id: id }, loadSuppliers);
    });
});
