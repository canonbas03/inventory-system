$(document).ready(function () {

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
     $(document).on("click", ".edit-product-btn", function (e) {
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

    // Search supplier
        $("#searchSupplier").on("keyup", loadSuppliers);

    // Edit supplier
        $(document).on("click", ".edit-supplier-btn", function (e) {
        e.preventDefault();

        let id = $(this).data("id");

        window.location.href = "../suppliers/edit.php?id=" + id;
    });

    // Delete supplier
        $(document).on("click", ".delete-supplier-btn", function (e) {
        e.preventDefault();

        if (!confirm("Delete this supplier?")) return;

        let id = $(this).data("id");

        $.post("/inventory/api/suppliers/delete_supplier.php", { id: id }, loadSuppliers);
    });


     // === CATAGORIES === \\

     loadCategories(); 
     function loadCategories() {
            $.ajax({
                url: "../api/categories/filter_categories.php",
                method: "GET",
                data: {
                    q: $("#search-category").val()
                },
                success: function(data) {
                    $("#category-table table").html(
                        "<tr><th>ID</th><th>Name</th><th>Actions</th></tr>" + data
                    );
                }
            });
        }

    // Search
        $("#search-category").on("keyup", loadCategories);

    // Edit category
        $(document).on("click", ".edit-category-btn", function (e) {
        e.preventDefault();

        let id = $(this).data("id");

        window.location.href = "../categories/edit.php?id=" + id;
    });

    // Delete category
    $(document).on("click", ".delete-category-btn", function (e) {
    e.preventDefault();

    if (!confirm("Delete this category?")) return;

    let id = $(this).data("id");

    $.post("/inventory/api/categories/delete_category.php", { id: id }, loadCategories);


});
});
